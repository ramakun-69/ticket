<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\MShift;
use Illuminate\Support\Str;
use App\Events\ShiftUpdated;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

class UpdateShift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-shift';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shift Updated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
     
        $shift = setShift();
        ShiftUpdated::dispatch(Str::upper($shift));
    }
}
