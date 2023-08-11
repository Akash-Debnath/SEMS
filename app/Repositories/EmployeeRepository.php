<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use App\Models\EmployeeEdit;
use App\Models\Grade;
use App\Models\Facility;
use App\Models\FacilityOption;
use App\Models\Status_log;
use Spatie\Permission\Models\Role;
use App\Traits\QueryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class EmployeeRepository implements RepositoryInterface
{

    use QueryTrait;

    /**
     * @author Akash Chandra Debnath
     * @method getAllEmployee
     * @param department_code
     * @return All_employees by their department
    */
    public function getAllEmployee($request)
    {
     
        $query = Employee::where('archive', '=', "N")->with(['department', 'userDesignation'])->orderByRaw('CONVERT(emp_id, Signed) ASC');

        if($request->dept_code) {
            $query->where('dept_code',$request->dept_code);
        }
        return $query->paginate(20);
    }



    /**
     * Show all employee from `employees` table
     * 
     * @author Akash Chandra Debnath
     * @method SearchEmployee
     * @param $request department_code
     * @return employees-data by their department
    */
    public function SearchEmployee($request)
    {
        $query = Employee::where('archive','=', "N");
        if($request->dept_code) 
        {
            $query->where('dept_code',$request->dept_code);
        }
        return $query->get();
    }



    /**
     * Get all departments from `departments` table
     * 
     * @author Akash Chandra Debnath
     * @method getEmployeeDepartment
     * @param 
     * @return All-departments
    */
    public function getEmployeeDepartment()
    {
        return Department::all();
    }



    /**
     * @author Akash Chandra Debnath
     * @method getEmployeeGrade
     * @param 
     * @return All-grades
    */
    public function getEmployeeGrade()
    {
        return Grade::all();
    }


    /**
     * @author Akash Chandra Debnath
     * @method getEmployeeDesignation
     * @param 
     * @return All-designations
    */
    public function getEmployeeDesignation()
    {
        return Designation::all();
    }
    
    
    /**
     * @author Akash Chandra Debnath
     * @method getFacility
     * @param employee-id
     * @return facilities of specific employee
    */
    public function getFacility($id)
    {
        return Facility::where('emp_id', '=', $id)->get();
    }


    /**
     * Get all status from `status_logs` table
     * 
     * @author Akash Chandra Debnath
     * @method getStatus
     * @param employee_id
     * @return All-departments
    */
    public function getStatus($id)
    {
        return Status_log::where('emp_id', '=', $id)->get();
    }



    /**
     * Get all facility from `facilities` table.
     * 
     * @author Akash Chandra Debnath
     * @method getAllFacility
     * @param 
     * @return All-facilities
    */
    public function getAllFacility()
    {
        return FacilityOption::all();
    }
    
    
    /**
     * @author Akash Chandra Debnath
     * @method getEmployeeDepartment
     * @param employee_id
     * @return employee_details
    */   
    public function getEmployeeInfo($id)
    {
        return Employee::where('emp_id', '=', $id)->first();
    }
    
    
    

    /**
     * Store new employee resources in `employees` and `users` table
     * 
     * @author Akash Chandra Debnath
     * @method createEmployee
     * @param $data employee- name, id, grade, dept...
     * @return void
    */
    public function createEmployee($data)
    {
        $employee = new Employee;
        $user = new User();

        $employee->name = $data->name;
        $employee->emp_id = $data->emp_id;
        $employee->grade_id = $data->grade;
        $employee->dept_code = $data->dept_code;
        $employee->designation = $data->designation;
        $employee->jdate = $data->jdate;
        $employee->status = $data->status;
        $employee->office_stime = $data->office_stime;
        $employee->office_etime = $data->office_etime;
        $employee->mobile = $data->mobile;
        $employee->phone = $data->phone;
        $employee->pass = Hash::make('welcome2244');
        $employee->email = $data->email;
        $employee->present_address = $data->present_address;
        $employee->permanent_address = $data->permanent_address;
        $employee->last_edu_achieve = $data->last_edu_achieve;
        $employee->dob = $data->dob;
        $employee->archive = "N";
        $employee->scheduled_attendance = "Y";
        $employee->online = "N";
        $employee->blood_group = $data->blood_group;
        $employee->gender = $data->gender;
        if($data->hasfile('image'))
        {  
            $file = $data->file('image');
            $name =$file->getClientOriginalName();
            $file->move(public_path('EmployeePhoto'), $name);
            $employee->image = $name; 
        }
        if($employee->save()) {
            $user->username = $data->emp_id;
            $user->email = $data->email;
            $user->password = Hash::make('welcome2244');
            if ($data->roles) {
                $user->assignRole($data->roles);
            }
            $user->save();
        }
        
        return;
    }



    /**
     * Get all roles from `roles` table.
     * 
     * @author Akash Chandra Debnath
     * @method getAllRoles
     * @param 
     * @return All-roles
    */
    public function getAllRoles()
    {
        return Role::all();
    }


    /**
     * Get specific user details  from `employees` table.
     * 
     * @author Akash Chandra Debnath
     * @method getUserInfo
     * @param $id employee_id
     * @return user_information
    */  
    public function getUserInfo($id)
    {
        $employee =  Employee::find($id);
        return User::where('username',$employee->emp_id)->first();    
    }


    /**
     * Show specific employee data for edit from `employees` table
     * 
     * @author Akash Chandra Debnath
     * @method editEmployee
     * @param $id employee_id
     * @return void 
    */
    public function editEmployee($id)
    {
        return Employee::find($id);
    }


    /**
     * Update specific employee resources in `employees` and `users` and `model_has_roles` table
     * 
     * @author Akash Chandra Debnath
     * @method updateEmployee
     * @param $data employee- name, id, grade, dept..., $id employee_id
     * @return void
    */
    public function updateEmployee($data, $id)
    {
        $employee = Employee::find($id);
        $employee->name = $data->name;
        // $employee->emp_id = $data->emp_id;
        $employee->grade_id = $data->grade;
        $employee->dept_code = $data->dept_code;
        $employee->designation = $data->designation;
        $employee->jdate = $data->jdate;
        $employee->status = $data->status;
        $employee->office_stime = $data->office_stime;
        $employee->office_etime = $data->office_etime;
        $employee->mobile = $data->mobile;
        $employee->phone = $data->phone;
        $employee->email = $data->email;
        $employee->present_address = $data->present_address;
        $employee->permanent_address = $data->permanent_address;
        $employee->last_edu_achieve = $data->last_edu_achieve;
        $employee->dob = $data->dob;
        $employee->blood_group = $data->blood_group;
        $employee->gender = $data->gender;
        if($data->hasfile('image'))
        {  
            $file = $data->file('image');
            $name =$file->getClientOriginalName();
            $file->move(public_path('EmployeePhoto'), $name);
            $employee->image = $name; 
        }


        $user = User::where('username',$employee->emp_id)->first();

        $user->roles()->detach();
        if ($data->roles) {
            $user->assignRole($data->roles);
        }
        return $employee->update(); 
    }



    /**
     * Remove specific employee from `employees` table
     * 
     * @author Akash Chandra Debnath
     * @method deleteEmployee
     * @param $id employee_id
     * @return void
    */
    public function deleteEmployee($id)
    {
        // return Employee::findorFail($id)->delete();
        $employee = Employee::find($id);
        User::where('username', $employee->emp_id)->delete();
        Employee::findorFail($id)->delete();
        return;

    }


    /**
     * Store new facility resources in `facilities` table
     * 
     * @author Akash Chandra Debnath
     * @method createFacility
     * @param $data employee-id, facility, date...
     * @return void
    */
    public function createFacility($data)
    {
        $facility = new Facility;
        $facility->emp_id = $data->emp_id;
        $facility->facility = $data->facility;
        $facility->remark = $data->remark;
        $facility->from_date = $data->from_date;
        $facility->to_date = $data->to_date;

        return $facility->save();
    }


    /**
     * Show specific employee data for edit from `facilities` table
     * 
     * @author Akash Chandra Debnath
     * @method editFacility
     * @param $id facility_id
     * @return void 
    */
    public function editFacility($id)
    {
        return Facility::where('id',$id)->first();
    }



    /**
     * Update specific facility resources in `facilities` table
     * 
     * @author Akash Chandra Debnath
     * @method updateFacility
     * @param $data employee-id, facility, date...
     * @return void
    */
    public function updateFacility($request)
    {
        $data = $request->input('facilityId');
        return Facility::where('id', $data)->update(['emp_id'=>$request->emp_id, 'facility'=>$request->facility, 'from_date'=>$request->from_date, 'to_date'=>$request->to_date, 'facility_id'=>$request->facility_id]);
    }


    /**
     * Remove specific facility from `facilities` table
     * 
     * @author Akash Chandra Debnath
     * @method deleteFacility
     * @param $id facility_id
     * @return void
    */
    public function deleteFacility($id)
    {
        return Facility::findorFail($id)->delete();
    }



    /**
     * Store new status resources in `status_logs` table
     * 
     * @author Akash Chandra Debnath
     * @method createStatus
     * @param $data employee-id, status, date
     * @return void
    */
    public function createStatus($data)
    {
        $status = new Status_log;
        // $statusUpdate = new Employee;

        $status->emp_id = $data->emp_id;
        $status->status = $data->status;
        $status->date = $data->date;
        $status->save();

        Employee::where('emp_id', $data->emp_id)->update(['status'=> $data->status]);

        return; 

    }


    /**
     * Remove specific status resources in `status_logs` table
     * 
     * @author Akash Chandra Debnath
     * @method deleteStatus
     * @param $id status_id
     * @return void
    */
    public function deleteStatus($id)
    {
        return Status_log::findorFail($id)->delete();
    }



    /**
     * Store new grade resources in `grades` table
     * 
     * @author Akash Chandra Debnath
     * @method createGrade
     * @param $data grade
     * @return void
    */
    public function createGrade($data)
    {
        $status = new Grade;
        $status->grade = $data->grade;
        return $status->save();
    }


    /**
     * Update specific grade resources in `grades` table
     * 
     * @author Akash Chandra Debnath
     * @method updateGrade
     * @param $data grade, $id grade_id
     * @return void
    */
    public function updateGrade($data, $id)
    {
        return Employee::where('emp_id', $id)->update(['grade_id'=> $data->grade_id]);
    }


    /**
     * Update specific employee archive status in `employees` table
     * 
     * @author Akash Chandra Debnath
     * @method employeeArchive
     * @param $data archive_data, $id employee_id
     * @return void
    */
    public function employeeArchive($data, $id)
    {
        return Employee::where('emp_id', $id)->update(['archive'=> $data->archive]);
    }


    /**
     * Store individual employee data in `employee_edits` table
     * 
     * @author Akash Chandra Debnath
     * @method editEmployeeInfo
     * @param $request name, mobile, address, experiance..
     * @return void
    */
    public function editEmployeeInfo($request)
    {
        $id = Auth::user()->username;
        // $request = array_filter($request->all());
        $data = array('emp_id'=>Auth::user()->username, 'mobile'=>$request->mobile, 'phone'=>$request->phone, 'present_address'=>$request->present_address, 'permanent_address'=>$request->permanent_address, 'last_edu_achieve'=>$request->last_edu_achieve, 'experiance'=>$request->experiance, 'dob'=>$request->dob, 'blood_group'=>$request->blood_group,'gender'=>$request->gender,'status'=> "N");

        return DB::table('employee_edits')->updateOrInsert(['emp_id'=>$id], $data);
    }


    /**
     * Get all profile update request from `employee_edits` table
     * 
     * @author Akash Chandra Debnath
     * @method profileUpdateRequest
     * @return employeeProfileUpdateRequests
    */
    public function profileUpdateRequest()
    {
        return EmployeeEdit::with('employee')->get();
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

    public static function filterEmployee($request, $query, array $whereFilterList, array $likeFilterList)
    {
        $query = self::likeQueryFilter($request, $query, $likeFilterList);
        $query = self::whereQueryFilter($request, $query, $whereFilterList);

        return $query;
    }

}