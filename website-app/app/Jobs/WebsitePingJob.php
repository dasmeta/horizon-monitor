<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WebsitePingJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $queue;

    public function __construct()
    {
        $this->queue = 'website-main';
    }

    public function handle(): void
    {
        logger()->info('🔵 Website PingJob ran at '.now());
        
        usleep(rand(0, 5000000));
    }
}