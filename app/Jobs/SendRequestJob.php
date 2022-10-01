<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\CurlDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $domain;
    private $curlDetail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($domain, $curlDetail)
    {
        $this->domain = $domain;
        $this->curlDetail = $curlDetail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $time = now();
        try{
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
            ])->timeout(10)->connectTimeout(9)->get('https://' . $this->domain->name);
        }catch(\Exception $e){
            $this->curlDetail->status = 'not_sent';
            $this->curlDetail->save();
            $this->sendNotification('handled by exception');
            return;
        }

        if ($response->successful()) {
            $this->curlDetail->status = 'online';
        } else {
            $this->curlDetail->status = 'offline';
            $this->sendNotification('is down');
        }
        $diff = now()->diffInMilliseconds($time);
        $this->curlDetail->response_time_milliseconds = $diff;
        $this->curlDetail->save();
    }

    // send notification to bonnier slack. add new websites for notification here:
    private function sendNotification($message)
    {
        $bonnierDomains = [
            'iform.dk',
            'militarhistoria.se',
            'admin.iform.dk',
            'iform.nu',
            'illvid.dk',
            'goerdetselv.dk',
            'site-manager.bonnier.cloud/admin/login',
            'translation-manager.bonnier.cloud/admin/login',
            'staging.cache-service.bonnier.cloud',
            'staging2.iform.dk',
            'admin-staging.illvid.dk',
            'iform.nu/trening/fitness',
        ];
        if( in_array( $this->domain->name, $bonnierDomains)){
            $dt = Carbon::now();
            Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('SLACK_NOTIFICATION_LINK'), [
                'text' => $this->domain->name . '=> ' . $message . '. =>' . $dt->toDayDateTimeString(),
            ]);
        }
    }
}
