<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Option;
use App\Models\Leave;

class LeaveGlanceRepository implements RepositoryInterface
{
    public function dept()
    {
        return Department::all();
    }

    public function option()
    {
        return Option::where('option_name', 'leave_type')->get();
    }

    public function leave($year)
    {

        return Leave::whereYear('leave_start', $year)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->get();
    }

    public function leaveByType($req)
    {
        $type = $req->type;
        return option::whereIn('option_code', $type)->where('option_name', 'leave_type')->get();
    }

    public function deptBysearch($req)
    {
        $edept = $req->department;
        return Department::whereIn('dept_code', $edept)->get();
    }
    public function all()
    {
        return true;
    }


    public function get($id)
    {
        return true;
    }



    public function create($data)
    {
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
