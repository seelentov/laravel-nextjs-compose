<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;

class Controller
{
    public function index()
    {
        for ($i = 0; $i < 100; $i++)
            //     TestJob::dispatch();
            Redis::set("key_" . $i, "asd");
    }
}
