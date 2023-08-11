<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Job_desc_files;
use App\Traits\QueryTrait;


use App\Models\Department;
use App\Models\Employee;

class JobDescriptionRepository implements RepositoryInterface
{


    public function getDepartment()
    {
        $emp = new Employee;
        $dept = new Department;
        return Department::orderBy('dept_name', 'ASC')->get();
    }

    public function getEmployee()
    {
        $emp = new Employee;
        return Employee::where('archive', '=', 'N')->get();
    }




    public function store($request)
    {
        $job = new job_desc_files;

        $data = array(

            'emp_id' => $request->input('empId'),

            'file_name' => $request->file->getClientOriginalName(),

        );
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('files/', $request->file->getClientOriginalName());
            $request->file = $filename;
        }

        return job_desc_files::create($data);
    }




    public function editJobDesc($id)
    {

        return Employee::where('id', $id)->first();
    }

    public function updateJobDesc($request,$id)
    {
        $id = $request->input('Id');

        $data = array(

            // 'emp_id' => $request->input('empId'),

            'file_name' => $request->files,

        );



        if ($request->hasfile('files')) {
            $file = $request->file('files');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('files/', $filename);
            $request->files = $filename;
        }
       
        return Job_desc_files::where('id', $id)->update($data);
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
