<?php
namespace App\Services;

use App\Repositories\AdministratorPrivilegeRepository;
use Illuminate\Support\Facades\Validator;

class AdministratorPrivilegeService 
{
    /**
     * @var administratorPrivilegeRepository
    */
    protected $administratorPrivilegeRepository;


    /**
     * UserService constructor.
     * @param AdministratorPrivilegeRepository $administratorPrivilegeRepository
     */
    public function __construct(AdministratorPrivilegeRepository $administratorPrivilegeRepository)
    {
        $this->administratorPrivilegeRepository = $administratorPrivilegeRepository;
    }


    public function getAllEmployee()
    {
        return $this->administratorPrivilegeRepository->all();
    }



    /**
     * Validate request data and store a newly created manager level privileger in storage by redirecting to administratorPrivilegeRepository.
     *
     * @author Akash Chandra Debnath
     * @param  \Illuminate\Http\Request $request employee_id, department_code, role_type
     * @return \Illuminate\Http\Response
    */
    public function addPrivileger($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required', 
            'dept_code' => 'required', 
            'type' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->administratorPrivilegeRepository->addPrivileger($request);
    }


    public function getAllPrivileger()
    {
        return $this->administratorPrivilegeRepository->getAllPrivileger();
    }


    public function getAllDepartment()
    {
        return $this->administratorPrivilegeRepository->getAllDepartment();
    }



    public function adminPrivilege($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required', 
            'type' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->administratorPrivilegeRepository->adminPrivilege($request);
    }


    public function rosterPrivilege($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required', 
            'type' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        

        return $this->administratorPrivilegeRepository->rosterPrivilege($request);
    }



    public function managementPrivilege($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required', 
            'type' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->administratorPrivilegeRepository->managementPrivilege($request);
    }



    public function deleteManager($id)
    {
        return $this->administratorPrivilegeRepository->delete($id); 
    }



    public function deleteAdmin($id)
    {
        return $this->administratorPrivilegeRepository->deleteAdmin($id); 
    }


    public function deleteRoster($id)
    {
        return $this->administratorPrivilegeRepository->deleteRoster($id); 
    }


    public function deleteManagement($id)
    {
        return $this->administratorPrivilegeRepository->deleteManagement($id); 
    }

}