<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\WebsitePingJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new WebsitePingJob)->everyMinute();

// Schedule::command('horizon:snapshot')->everyFiveMinutes()->withoutOverlapping();