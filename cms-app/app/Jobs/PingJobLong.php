<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingJobLong implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $queue;

    public function __construct()
    {
        $this->queue = 'cms-long';
    }

    public function handle(): void
    {
        logger()->info('CMS PingJobLong ran at '.now());

        usleep(rand(5000000, 50000000));
    }
}