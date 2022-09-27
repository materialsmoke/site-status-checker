<?php

namespace App\Console;

use App\Jobs\CheckSitemapJob;
use App\Jobs\SendRequestJob;
use App\Models\CheckSitemapDomain;
use App\Models\CurlDetail;
use App\Models\Domain;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $domains = Domain::where('is_active', true)->where('type', '=', 'response-check')->get();
            foreach ($domains as $domain) {
                $curlDetail = CurlDetail::create([
                    'domain_id' => $domain->id,
                    'status' => 'start',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                SendRequestJob::dispatch($domain, $curlDetail);
            }
        })->everyMinute();

        $schedule->call(function(){
            $domains = Domain::where('is_active', true)->where('type', '=', 'sitemap-check')->get();
            foreach($domains as $domain){
                $checkSitemapDomain = CheckSitemapDomain::create([
                    'domain_id' => $domain->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                CheckSitemapJob::dispatch($domain, $checkSitemapDomain);
            }
        })->everyFourHours();//->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
