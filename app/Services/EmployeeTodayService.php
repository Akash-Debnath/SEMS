<?php

namespace App\Services;


use App\Repositories\EmployeeTodayRepository;

class EmployeeTodayService
{
    protected $employeeTodayRepository;

    public function __construct(EmployeeTodayRepository $employeeTodayRepository)
    {
        $this->EmployeeTodayRepository = $employeeTodayRepository;
    }

    public function Roster()
    {
        return $this->EmployeeTodayRepository->Roster();
    }

    public function Department()
    {
        return $this->EmployeeTodayRepository->Department();
    }

    public function Employee()
    {
        return $this->EmployeeTodayRepository->Employee();
    }

    public function  defaultTime()
    {
        return $this->EmployeeTodayRepository->defaultTime();
    }

    public function defaultWeekend(){
        return $this->EmployeeTodayRepository->defaultWeekend();
    }
}
