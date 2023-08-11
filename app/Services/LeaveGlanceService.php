<?php

namespace App\Services;

use App\Repositories\LeaveGlanceRepository;

class LeaveGlanceService
{
    protected $leaveGlanceRepository;

    public function __construct(LeaveGlanceRepository $leaveGlanceRepository)
    {
        $this->LeaveGlanceRepository = $leaveGlanceRepository;
    }

    public function dept()
    {
        return  $this->LeaveGlanceRepository->dept();
    }

    public function option()
    {
        return $this->LeaveGlanceRepository->option();
    }

    public function leave($year)
    {
        return $this->LeaveGlanceRepository->leave($year);
    }

    public function leaveByType($req)
    {

        return $this->LeaveGlanceRepository->leaveByType($req);
    }

    public function deptBysearch($req)
    {

        return $this->LeaveGlanceRepository->deptBysearch($req);
    }
}
