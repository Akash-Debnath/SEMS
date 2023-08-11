<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\WeeklyLeave;
use App\Traits\QueryTrait;
use Illuminate\Support\Facades\Auth;


class OfficeTimeRepository implements RepositoryInterface
{

    public function all()
    {
        return Employee::where('archive', '=', "N")->with('department')->orderByRaw('CONVERT(emp_id, Signed) ASC')->get();
    }


    public function getAllWeekLeaves()
    {
        return WeeklyLeave::all();
    }

    
    public function getAllDepartment()
    {
        return Department::with('employee')->orderBy('dept_name', 'ASC')->get();
    }


    public function updateSchedule($data, $id)
    {
        return Employee::where('emp_id', $id)->update(['scheduled_attendance'=> $data->scheduled_attendance]);
    }


    public function updateRoster($data, $id)
    {
        return Employee::where('emp_id', $id)->update(['roster'=> $data->roster]);
    }



    public function get($id)
    {
        return true;
    }



    public function create($data)
    {
        return true;
    }



    public function update(array $data, $id)
    {
        return true;
    }



    public function delete($id)
    {
        return WeeklyLeave::findorFail($id)->delete();
    }



    public function deleteAdmin($id)
    {
        return WeeklyLeave::findorFail($id)->delete();
    }


    public function deleteRoster($id)
    {
        return WeeklyLeave::findorFail($id)->delete();
    }


    public function deleteManagement($id)
    {
        return WeeklyLeave::findorFail($id)->delete();
    }

}