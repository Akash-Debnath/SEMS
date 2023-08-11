<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\PermissionPrivilege;
use App\models\ActivityPermission;
use App\Traits\QueryTrait;


class PermissionPrivilegeRepository implements RepositoryInterface
{

    use QueryTrait;


    public function all()
    {
        return PermissionPrivilege::all();
    }


    public function getAllEmployee()
    {
        return Employee::where('archive', '=', 'N')->orderByRaw('CONVERT(emp_id, Signed) ASC')->get();
    }


    public function getAllDepartment()
    {
        return Department::orderBy('dept_name', 'ASC')->get();
    }


    public function get($id)
    {
        return true;
    }


    public function createPermission($data)
    {
        for($i = 0; $i < count($data->staff_id); $i++)
        {
        $per[] =
            [
                'activity_id' => $data->activity_id,
                'privileger_id' => $data->privileger_id,
                'staff_id' => $data->staff_id[$i],
                'created_at' => date('Y-m-d h:i:s')           
            ];
        }
        return ActivityPermission::insert($per);
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