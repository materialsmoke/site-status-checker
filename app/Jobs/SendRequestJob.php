<?php

namespace App\Jobs;

use App\Models\CurlDetail;
use Illuminate\Bus\Queueable;
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
            $response = Http::timeout(10)->connectTimeout(9)->get('https://' . $this->domain->name);
        }catch(\Exception $e){
            // CurlDetail::create([
            //     'domain_id' => $this->domain->id,
            //     'status' => 'wait',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            $this->curlDetail->status = 'not_sent';
            $this->curlDetail->save();
            return;
        }

        if ($response->successful()) {
            // CurlDetail::create([
            //     'domain_id' => $this->domain->id,
            //     'status' => 'online',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            $this->curlDetail->status = 'online';
        } else {
            // CurlDetail::create([
            //     'domain_id' => $this->domain->id,
            //     'status' => 'offline',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            $this->curlDetail->status = 'offline';
        }
        $diff = now()->diffInMilliseconds($time);
        $this->curlDetail->response_time_milliseconds = $diff;
        $this->curlDetail->save();
    }
}
