<?php

namespace App\Services;


use App\Repositories\OfficeScheduleRepository;
use Illuminate\Support\Facades\Validator;

class OfficeScheduleService
{

    /**
     * @var officeScheduleRepository
     */
    protected $officeScheduleRepository;


    /**
     * UserService constructor.
     * @param officeScheduleRepository $officeScheduleRepository
     */
    public function __construct(OfficeScheduleRepository $officeScheduleRepository)
    {
        $this->officeScheduleRepository = $officeScheduleRepository;
    }



    public function Department()
    {
        return $this->officeScheduleRepository->Department();
    }

    public function defaultWeekend()
    {
        return $this->officeScheduleRepository->defaultWeekend();
    }

    public function defaultTime()
    {
       return $this->officeScheduleRepository->defaultTime();
    }

    public function Holiday()
    {
        return $this->officeScheduleRepository->Holiday();
    }

    public function Ramadan()
    {
        return $this->officeScheduleRepository->Ramadan();
    }

    public function employeeByEmpId($emp_id)
    {
        return $this->officeScheduleRepository->employeeByEmpId($emp_id);
    }

    public function employeeBydept($dept)
    {
        return $this->officeScheduleRepository->employeeBydept($dept);
    }
    public function checkRoster($emp_id)
    {
        return $this->officeScheduleRepository->checkRoster($emp_id);
    }

    public function RosterSlot($dept)
    {
        return $this->officeScheduleRepository->RosterSlot($dept);
    }
}
