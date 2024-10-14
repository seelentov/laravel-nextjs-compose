<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Queue;

class Controller
{
    public function index()
    {
        $when = now()->addMinutes(10);

        TestJob::dispatch();
    }
}
