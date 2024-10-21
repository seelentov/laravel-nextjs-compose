<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class TestJob implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this
            ->onConnection('rabbitmq')
            ->onQueue('test');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
    }
}
