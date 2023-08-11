<?php
namespace App\Services;


use App\Repositories\EmployeeRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class EmployeeService 
{

    /**
     * @var EmployeeRepository
    */
    protected $employeeRepository;


    /**
     * UserService constructor.
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    /**
     * Display a listing of all employees resource by directing to employeeRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllEmployee
     * @param void
     * @return \Illuminate\Http\Response
    */
    public function getAllEmployee($request)
    {
        return $this->employeeRepository->getAllEmployee($request); 
    }


        /**
     * Display a listing of all employees resource by directing to employeeRepository.
     *
     * @author Akash Chandra Debnath
     * @method SearchEmployee
     * @param $request department_code
     * @return \Illuminate\Http\Response
    */
    public function SearchEmployee($request)
    {
        return $this->employeeRepository->SearchEmployee($request); 
    }



    /**
     * Get all departments from storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getEmployeeDepartment
     * @param 
     * @return All-departments
    */
    public function getEmployeeDepartment()
    {
        return $this->employeeRepository->getEmployeeDepartment(); 
    }
    
    

    /**
     * Get all grades from storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getEmployeeGrade
     * @param void 
     * @return All-grades
    */
    public function getEmployeeGrade()
    {
        return $this->employeeRepository->getEmployeeGrade(); 
    }


    /**
     * Get all employee designations from designation by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getEmployeeDesignation
     * @param 
     * @return All-designations
    */
    public function getEmployeeDesignation()
    {
        return $this->employeeRepository->getEmployeeDesignation(); 
    }


    
    /**
     * Get specific employee details from storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getEmployeeInfo
     * @param employee_id
     * @return employee_details
    */  
    public function getEmployeeInfo($id)
    {
        return $this->employeeRepository->getEmployeeInfo($id); 
    }
    
    
    /**
     * Get all facility from storage by directing to .
     * 
     * @author Akash Chandra Debnath
     * @method getAllFacility
     * @param 
     * @return All-facilities
    */
    public function getFacility($id)
    {
        return $this->employeeRepository->getFacility($id); 
    }


    /**
     * Get status of specific employee from storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getStatus
     * @param employee_id
     * @return All-departments
    */
    public function getStatus($id)
    {
        return $this->employeeRepository->getStatus($id); 
    }
    
    
    /**
     * Get all facility from `storage by directing to employeeRepository.
     * 
     * @author Akash Chandra Debnath
     * @method getAllFacility
     * @param 
     * @return All-facilities
    */
    public function getAllFacility()
    {
        return $this->employeeRepository->getAllFacility(); 
    }
    
    
    /**
     * Validate all request data and store new employee resources in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method createEmployee
     * @param $data employee- name, id, grade, dept...
     * @return void
    */
    public function createEmployee($request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required', 
            'emp_id' => 'required|unique:employees', 
            'dept_code' => 'required', 
            'designation' => 'required', 
            // 'email' => 'required|email|max:60|unique:employees',
            'jdate'=>'required', 
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        $this->employeeRepository->createEmployee($request); 
    }
    
    
  
    
    /**
     * Get all roles in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getAllRoles
     * @param void
     * @return All-roles
    */
    public function getAllRoles()
    {
        return $this->employeeRepository->getAllRoles();
    }



    /**
     * Get specific user details  in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method getUserInfo
     * @param $id employee_id
     * @return user_information
    */ 
    public function getUserInfo($id)
    {
        return $this->employeeRepository->getUserInfo($id);
    }

    
  
    /**
     * Show specific employee data for edit in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method editEmployee
     * @param $id employee_id
     * @return void 
    */
    public function editEmployee($id)
    {
        return $this->employeeRepository->editEmployee($id); 
    }

    
  
    /**
     * Validate request data and update specific employee resources in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method updateEmployee
     * @param $data employee- name, id, grade, dept..., $id employee_id
     * @return void
    */
    public function updateEmployee($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required', 
            // 'emp_id' => ['required',Rule::unique('employees')->where(function ($query) use ($id) {
            //     return $query->where('id', '!=', $id);
            // })],
            'dept_code' => 'required', 
            'designation' => 'required', 
            'email' => ['required','min:3','max:100',Rule::unique('employees')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
            'jdate'=>'required', 
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->employeeRepository->updateEmployee($request, $id); 
    }
    
    
    
    /**
     * Remove specific employee in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method deleteEmployee
     * @param $id employee_id
     * @return void
    */
    public function deleteEmployee($id)
    {
        return $this->employeeRepository->deleteEmployee($id); 
    }
   
    
   
    /**
     * validate request data and store new facility resources in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method createFacility
     * @param $data employee-id, facility, date...
     * @return void
    */
    public function createFacility($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required',
            'facility' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $this->employeeRepository->createFacility($request); 
    
    }


    /**
     * Show specific employee data as response for edit in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method editFacility
     * @param $id facility_id
     * @return void 
    */
    public function editFacility($id)
    {   
        $data = $this->employeeRepository->editFacility($id);
        

        return response()->json([
            'status'=>200,
            'facilitydata'=>$this->employeeRepository->editFacility($id)
        ]);
    }



    /**
     * Validate and update specific facility resources in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method updateFacility
     * @param $data employee-id, facility, date...
     * @return void
    */
    public function updateFacility($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required',
            'facility' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->employeeRepository->updateFacility($request); 
    }



    /**
     * Remove specific facility in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method deleteFacility
     * @param $id facility_id
     * @return void
    */
    public function deleteFacility($id)
    {
        return $this->employeeRepository->deleteFacility($id); 
    }



    /**
     * validate request data and store new status resources in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method createStatus
     * @param $data employee-id, status, date
     * @return void
    */
    public function createStatus($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $this->employeeRepository->createStatus($request); 
    
    }



    /**
     * Remove specific status resources in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method deleteStatus
     * @param $id status_id
     * @return void
    */
    public function deleteStatus($id)
    {
        return $this->employeeRepository->deleteStatus($id); 
    }



    /**
     * validate request data and store new grade resources in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method createGrade
     * @param $data grade
     * @return void
    */
    public function createGrade($request)
    {
        $validator = Validator::make($request->all(),[
            'grade' => 'required|unique:grades',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $this->employeeRepository->createGrade($request); 
    
    }



    /**
     * Validate request data and pdate specific grade resources in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method updateGrade
     * @param $data grade, $id grade_id
     * @return void
    */
    public function updateGrade($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'grade_id' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $this->employeeRepository->updateGrade($request, $id); 
    }



    /**
     * Validate request data and update specific employee archive status in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method employeeArchive
     * @param $data archive_data, $id employee_id
     * @return void
    */
    public function employeeArchive($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'archive' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

    
        $this->employeeRepository->employeeArchive($request, $id); 
    }



    /**
     * Store individual employee data in storage by directing to employeeRepository
     * 
     * @author Akash Chandra Debnath
     * @method editEmployeeInfo
     * @param $request name, mobile, address, experiance..
     * @return void
    */
    public function editEmployeeInfo($request)
    {
        $request->validate([
            
        ]);
        $this->employeeRepository->editEmployeeInfo($request);
    }


    
    /**
     * Get all profile update request in storage by directing to employeeRepository 
     * 
     * @author Akash Chandra Debnath
     * @method profileUpdateRequest
     * @return employeeProfileUpdateRequests
    */
    public function profileUpdateRequest()
    {
        return $this->employeeRepository->profileUpdateRequest();
    }
    
}