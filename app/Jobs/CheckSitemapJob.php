<?php

namespace App\Jobs;

use App\Models\CheckSitemapDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $domain;
    private $checkSitemapDomain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain, $checkSitemapDomain)
    {
        $this->domain = $domain;
        $this->checkSitemapDomain = $checkSitemapDomain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.5195.125 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
            ])->timeout(10)->connectTimeout(9)->get('https://' . $this->domain->name);
        }catch(\Exception $e){
            $this->checkSitemapDomain->status = 'no-response';
            $this->checkSitemapDomain->save();

            return;
        }

        if ($response->successful()) {
            $content = $response->getBody()->getContents();
            if(strlen($content > 0)){
                $items = json_decode($content)->data->items;
                $itemsStr = json_encode($items);
                $this->checkSitemapDomain->content = $itemsStr;
                $this->checkSitemapDomain->str_length = strlen($itemsStr);
                $countItems = count($items);
                $this->checkSitemapDomain->rows_number = $countItems;
                $this->checkSitemapDomain->save();
                $lastTwoPreviousCheckSitemapDomain = CheckSitemapDomain::where('domain_id', $this->domain->id)->orderBy('created_at', 'desc')->limit(2)->get();
                if($lastTwoPreviousCheckSitemapDomain && count($lastTwoPreviousCheckSitemapDomain) == 2){
                    $previousCheckSitemapDomain = $lastTwoPreviousCheckSitemapDomain[1];
                    if($previousCheckSitemapDomain->str_length == $this->checkSitemapDomain->str_length){
                        $this->checkSitemapDomain->status = 'not-updated';
                    }else{
                        $this->checkSitemapDomain->status = 'updated';
                    }
                    // dd($countItems);
                    if(substr_count($itemsStr, 'https:\/\/') == $countItems){
                        $this->checkSitemapDomain->is_healthy = true;
                    }else{
                        $this->checkSitemapDomain->is_healthy = false;
                    }
                    
                    $previousItems = json_decode($previousCheckSitemapDomain->content);
                    // dd($previousItems);
                    $differencesArray = [];
                    $i = 0;
                    $bigger = $items;
                    $smaller = $previousItems;
                    $biggerStatus = 'items';
                    if(count($bigger) < count($smaller)){
                        $bigger = $previousItems;
                        $smaller = $items;
                        $biggerStatus = 'previousItems';
                    }
                    foreach($bigger as $item){
                        if((array_key_exists($i, $smaller)) && ($item->loc !== $smaller[$i]->loc)){
                            if($biggerStatus == 'items'){
                                $differencesArray[] = ['old' => $smaller[$i]->loc, 'new' => $item->loc];
                            }else{
                                $differencesArray[] = ['old' => $item->loc, 'new' => $bigger[$i]->loc];
                            }
                        }
                        if(! array_key_exists($i, $smaller)){
                            if($biggerStatus == 'items'){
                                $differencesArray[] = ['old' => '', 'new' => $item->loc];
                            }else{
                                $differencesArray[] = ['old' => $item->loc, 'new' => ''];
                            }
                        }
                        $i++;
                    }
                    $this->checkSitemapDomain->differences_content = json_encode($differencesArray);

                    $this->checkSitemapDomain->save();
                }
                // dd($previousCheckSitemapDomain)
            }
            
        } else {
            $this->checkSitemapDomain->status = 'no-response';
            $this->checkSitemapDomain->save();

            return;
        }
    }
}
