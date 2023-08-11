<?php

namespace App\Repositories;

use App\Models\Designation;
use App\Models\Department;

class DesignationRepository implements RepositoryInterface
{
    
    public function getAllDesignation()
    {  
       $dptCode = request()->query()['dept']??null;
       if($dptCode && $dptCode!="all"){
        return  Designation::whereDeptCode($dptCode)->paginate(20);
       }
       return Designation::paginate(20);
    }


    public function getEmployeeDepartment()
    {
        return Department::orderBy('dept_name', 'ASC')->get();
    }


    public function createDesignation($data)
    {
        $designation = Designation::create(['dept_code' => $data->dept_code, 'designation' => $data->designation]);
        return $designation->save();
    }


    public function editDesignation($id)
    {
        return Designation::where('id',$id)->first();
    }


    public function updateDesignation($request)
    {

        $data = $request->input('designationId');
        return $designation = Designation::where('id', $data)->update(['dept_code'=>$request->dept_code, 'designation'=>$request->designation]);

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
        return Designation::findorFail($id)->delete();

    }

}