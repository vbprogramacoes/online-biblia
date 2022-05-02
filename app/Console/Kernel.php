<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call($this->setDailyVerses())->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    /*
     * Get the daily verse randomly;
     * Set the daily verse with today;
     * Verify usage of all verses, if all verses are used set them as unused (used = false)
     * except the verses that will be used today; 
     * @return true
    */
    protected function setDailyVerses()
    {

        if (DB::table('dailyverses')->where('used', false)->count() == 0) {
            //VERIFY ALL DAILY VERSES USED AND UPDATE THEM

            DB::table('dailyverses')->update(['used' => false]);
        }
        $randdv = rand(1,2); //amount randonly daily verses
        $dva    = array();
        while(count($dva) < $randdv) {

            $countalldailyverses = DB::table('dailyverses')->count();
            $dv     = DB::table('dailyverses')->select('id')->where('used', false)->
                      where('today', false)->inRandomOrder()->first();
            DB::table('dailyverses')->where('id', $dv->id)->limit(1)->update(['today' => true]);
            DB::table('dailyverses')->where('id', $dv->id)->limit(1)->update(['used' => true]);
            if (DB::table('dailyverses')->where('used', false)->count() == 0) {
                //VERIFY ALL DAILY VERSES USED AND UPDATE THEM
                
                DB::table('dailyverses')->whereRaw("id not in($dv->id)")->update(['used' => false]);
            }
            $dva[]  = $dv->id;
        }

        //update all daily verses except the daily verses will be used today
        $sdva = implode(',', $dva);
        DB::table('dailyverses')->whereRaw("id not in($sdva)")->update(['today' => false]);

        return 'OK';
    }
}
