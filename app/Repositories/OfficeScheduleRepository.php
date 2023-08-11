<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Option;
use App\Models\Rostering;
use App\Models\RosterSlot;
use App\Models\Employee;
use App\Models\Holyday;
use App\Models\Weekend;
use App\Models\RamadanOfficeTime;

class OfficeScheduleRepository implements RepositoryInterface
{
    public function Department()
    {
        return Department::all();
    }
    
    public function defaultWeekend(){
        return Option::where('option_name', 'default_weekend')->get();
    }

    public function defaultTime(){
        return Option::where('option_name', 'default_time')->first();
    }

    public function Holiday(){
        return Holyday::all();
    }

    public function Ramadan(){
        return RamadanOfficeTime::all();
    }
    
    public function employeeByEmpId($emp_id){
       return Employee::where('emp_id', $emp_id)->get();
    }

    public function employeeBydept($dept){
        return Employee::where('dept_code', $dept)->where('archive', 'N')->get();
    }
    
    public function checkRoster($emp_id){
        return Employee::where('emp_id', $emp_id)->first();
    }
    public function RosterSlot($dept){
        return RosterSlot::where('dept_code', $dept)->get();
    }
    public function all()
    {
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
        return true;
    }
}
