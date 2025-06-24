<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $queue;

    public function __construct()
    {
        $this->queue = 'cms-main';
    }

    public function handle(): void
    {
        logger()->info('CMS PingJob ran at '.now());

        usleep(rand(0, 5000000));
    }
}