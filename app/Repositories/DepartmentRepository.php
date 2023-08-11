<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository implements RepositoryInterface
{
    /**
     * Display a listing of all departments resource sorting by deartment name from `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function getAllDepartment()
    {
       return Department::orderBy('dept_name', 'ASC')->paginate(20);
    }



    /**
     * Store a newly created department resource in `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method createDepartment
     * @param  \Illuminate\Http\Request  $request department_code, roster_status
     * @return \Illuminate\Http\Response
     */
    public function createDepartment($data, $dept_code)
    {
        $departments = Department::create(['dept_code'=>$dept_code,'dept_name' => $data->dept_name, 'isSlot'=>$data->roster_status, 'active'=>"Y"]);
        return $departments->save();
    }



    /**
     * Send data for edit the specified department resource from `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method editDepartment
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function editDepartment($id)
    {
        return Department::where('id',$id)->first();
    }



    /**
     * Update the specified department resource in `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method updateDepartment
     * @param  \Illuminate\Http\Request  $request department_code
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function updateDepartment($request)
    {
        $data = $request->input('deptId');
        return Department::where('id', $data)->update(['dept_name'=>$request->dept_name, 'isSlot'=>$request->roster_status]);
    }



    /**
     * Remove the specified department resource from `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method deleteDepartment
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function deleteDepartment($id)
    {
        return Department::findorFail($id)->delete();
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