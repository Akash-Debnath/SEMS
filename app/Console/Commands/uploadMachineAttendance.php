<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AttendanceApiService;

class uploadMachineAttendance extends Command
{

    /**
     * @var attendanceApiService
     */
    protected $attendanceApiService;



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:upmachinedata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Machine Attendance From Machine Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->attendanceApiService =  new AttendanceApiService;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->attendanceApiService->getMachineInstance();
    }
}
