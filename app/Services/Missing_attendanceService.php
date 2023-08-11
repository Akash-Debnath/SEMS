<?php

namespace App\Services;

use App\Repositories\Missing_attendanceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class Missing_attendanceService
{
    public function __construct(Missing_attendanceRepository $missing_attendanceRepository)
    {
        $this->Missing_attendanceRepository = $missing_attendanceRepository;
    }

    public function get_employee()
    {
        return $this->Missing_attendanceRepository->get_employee();
    }

    public function approve()
    {
        return $this->Missing_attendanceRepository->approve();
    }

    public function verify()
    {
        return $this->Missing_attendanceRepository->verify();
    }




    // approve attendance req


    public function get_Missing_id($id)
    {
        return $this->Missing_attendanceRepository->get_Missing_id($id);
    }

    public function update_Missing_id($id)
    {

        return $this->Missing_attendanceRepository->update_Missing_id($id);
    }




    // verify attendance req

    public function update_verified_missing_att($id)
    {
        return $this->Missing_attendanceRepository->update_verified_missing_att($id);
    }

    public function add_att($add_att)
    {
        return $this->Missing_attendanceRepository->add_att($add_att);
    }


    // upload---------------------------------------------
    public function get_dept()
    {
        return $this->Missing_attendanceRepository->get_dept();
    }

    // upload attendance-file

    public function attendance_file($req)
    {
        return $this->Missing_attendanceRepository->attendance_file($req);
    }


    // upload training attendance file

    public function training_attendance($req)
    {
        return $this->Missing_attendanceRepository->training_attendance($req);
    }

    // attendance store


    public function store($request)
    {
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'staff'=>'required',
            'in' => 'required',
            'out'=>'required',
        ]);
        return $this->Missing_attendanceRepository->store($request);
    }

    public function check_d($request)
    {
        return $this->Missing_attendanceRepository->check_d($request);
    }



    // report

    public function get_report($staff)
    {
        return $this->Missing_attendanceRepository->get_report($staff);
    }

    public function get_holiday()
    {
        return $this->Missing_attendanceRepository->get_holiday();
    }

    public function roster_dept()
    {
        return $this->Missing_attendanceRepository->roster_dept();
    }

    public function weekend($staff)
    {
        return $this->Missing_attendanceRepository->weekend($staff);
    }

    public function default_weekend()
    {
        return $this->Missing_attendanceRepository->default_weekend();
    }

    public function get_leave($staff)
    {

        return $this->Missing_attendanceRepository->get_leave($staff);
    }

    public function rostering($staff)
    {
        return $this->Missing_attendanceRepository->rostering($staff);
    }

    public function default_time()
    {
        return $this->Missing_attendanceRepository->default_time();
    }

    public function incident()
    {
        return $this->Missing_attendanceRepository->incident();
    }

    public function ramadan()
    {
        return $this->Missing_attendanceRepository->ramadan();
    }

    public function emp_roster_schedule($staff)
    {
        return $this->Missing_attendanceRepository->emp_roster_schedule($staff);
    }

    public function roster_holiday($staff)
    {
        return $this->Missing_attendanceRepository->roster_holiday($staff);
    }

    public function weeklyLeave($staff){
        return $this->Missing_attendanceRepository->weeklyLeave($staff);
    }


    public function all()
    {
        return true;
    }


    public function get($id)
    {
        return true;
    }



    public function create(array $data)
    {
        return true;
    }



    public function update(array $data, $id)
    {
        return true;
    }



    public function delete($id)
    {
        return $this->Missing_attendanceRepository->delete($id);
    }
}
