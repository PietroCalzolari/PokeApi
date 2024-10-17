<?php

use App\Console\Commands\Import;
use Illuminate\Support\Facades\Schedule;

Schedule::command(Import::class)->dailyAt('3:00');
