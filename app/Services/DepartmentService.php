<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\Validator;

class DepartmentService 
{
    /**
     * @var departmentRepository
    */
    protected $departmentRepository;


    /**
     * UserService constructor.
     * @param departmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }



    public function getAllDepartment()
    {
        return $this->departmentRepository->getAllDepartment(); 
    }



    public function createDepartment($request)
    {
        $validator = Validator::make($request->all(),[
            'dept_name' => 'required|unique:departments', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $dept_code = Helper::deptCodeGenerator($request->dept_name);
        $this->departmentRepository->createDepartment($request,$dept_code); 
    }



    public function editDepartment($id)
    {   
        $data = $this->departmentRepository->editDepartment($id);

        return response()->json([
            'status'=>200,
            'department'=>$this->departmentRepository->editDepartment($id)
        ]);
    }



    public function updateDepartment($request)
    {

        $validator = Validator::make($request->all(),[
            'dept_name' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->departmentRepository->updateDepartment($request); 
    }

    

    public function deleteDepartment($id)
    {
        return $this->departmentRepository->deleteDepartment($id); 
    }


}