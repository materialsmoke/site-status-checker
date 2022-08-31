<?php

namespace App\Console;

use App\Jobs\SendRequestJob;
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
            // $myfile = fopen("testfilekdsjfjdsfkj.txt", "a");
            // $txt = now() . "\n";
            // fwrite($myfile, $txt);
            // fclose($myfile);

            $domains = Domain::where('is_active', true)->get();
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
