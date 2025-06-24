<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\PingJob;
use App\Jobs\PingJobLong;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new PingJob)->everyMinute();

Schedule::job(new PingJobLong)->everyMinute();

Schedule::command('horizon:snapshot')->everyFiveMinutes();
