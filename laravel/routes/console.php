<?php

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new TestJob)->everyMinute();
