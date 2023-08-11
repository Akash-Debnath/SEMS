<?php

namespace App\Repositories;

use App\Models\Employee;

class ArchiveRepository implements RepositoryInterface
{
    
    public function getAllArchiveEmployee()
    {
       return $employee = Employee::where('archive', '=', "Y")->with(['department', 'userDesignation'])->paginate(20);
    }


    public function getEmployeeInfo($id)
    {
        return $employeeInfo = Employee::where('emp_id', '=', $id)->first();
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
        return true;
    }

}