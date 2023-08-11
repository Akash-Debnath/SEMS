<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * @var employeeService
     */
    protected $employeeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of all employees resource by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @param $request department_code
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $employees= $this->employeeService->getAllEmployee($request);
        $employeeSearch= $this->employeeService->SearchEmployee($request);
        $employeeDept= $this->employeeService->getEmployeeDepartment();
        $employeeDesignation= $this->employeeService->getEmployeeDesignation();
        $employeeGrade= $this->employeeService->getEmployeeGrade();
        return view('employeelist', compact('employees', 'employeeSearch', 'employeeDept', 'employeeDesignation', 'employeeGrade'));
    }



    /**
     * Show the form for creating a new employee by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method create
     * @param void
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        if(Auth::user()->can('employee-create')){

            $employeeDept= $this->employeeService->getEmployeeDepartment();
            $employeeDesignation= $this->employeeService->getEmployeeDesignation();
            $employeeGrade= $this->employeeService->getEmployeeGrade();
            $roles = $this->employeeService->getAllRoles();
            return view('add-employee', compact('employeeDept', 'employeeDesignation','employeeGrade', 'roles'));
            
        } else{
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }

    }

    /**
     * Store a newly created employee in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request employee_all_details_info
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('employee-create')){
            $this->employeeService->createEmployee($request);
            return redirect()->back()->with('success', 'Employee Added Successfully!');
        } else{
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Display the specified employee information by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method show
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response employee_all_info
    */
    public function show($id)
    {
        $empInfo = $this->employeeService->getEmployeeInfo($id);
        $facility = $this->employeeService->getAllFacility();
        $faci = $this->employeeService->getFacility($id);
        $stat = $this->employeeService->getStatus($id);
        $employeeGrade= $this->employeeService->getEmployeeGrade();

        return view('employee-details',compact('empInfo','faci','facility','stat', 'employeeGrade'));
    }

    /**
     * Show the form for editing the specified employee by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if(Auth::user()->can('employee-edit')){
            $employees = $this->employeeService->editEmployee($id);
            $employeeDept= $this->employeeService->getEmployeeDepartment();
            $employeeDesignation= $this->employeeService->getEmployeeDesignation();
            $employeeGrade= $this->employeeService->getEmployeeGrade();
            $roles = $this->employeeService->getAllRoles();
            $user = $this->employeeService->getUserInfo($id);

            return view('edit-employee', compact('employeeDept', 'employeeDesignation','employeeGrade', 'employees', 'roles', 'user'));
        } else{
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified resource in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request employee_all_information
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('employee-edit')){
            $this->employeeService->updateEmployee($request, $id);
            return redirect()->route('employees.index')->with('success','Employee Details Updated Successfully!');
        } else{
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified employee from storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('employee-edit')){
            $this->employeeService->deleteEmployee($id);
            return redirect()->route('employees.index')->with('fail','Employee Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Store a newly created status in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method createStatus
     * @param  \Illuminate\Http\Request  $request status, status_date
     * @return \Illuminate\Http\Response
    */
    public function createFacility(Request $request)
    {
        if(Auth::user()->can('facility-create')){
            $this->employeeService->createFacility($request);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Show the form for editing the specified facility by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method editFacility
     * @param  int  $id facility_id
     * @return \Illuminate\Http\Response
    */
    public function editFacility($id)
    {
        if(Auth::user()->can('facility-edit')){
            return $this->employeeService->editFacility($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified facility in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method updateFacility
     * @param  \Illuminate\Http\Request  $request facility_id, facility_description
     * @return \Illuminate\Http\Response
    */
    public function updateFacility(Request $request)
    {
        if(Auth::user()->can('facility-edit')){
            $this->employeeService->updateFacility($request);
            return redirect()->back()->with('success','Facility updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove the specified employees facility from storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method deleteFacility
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function deleteFacility($id)
    {
        if(Auth::user()->can('facility-delete')){
            $this->employeeService->deleteFacility($id);
            return redirect()->back()->with('fail','Facility Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Store a newly created status in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method createStatus
     * @param  \Illuminate\Http\Request  $request status, status_date
     * @return \Illuminate\Http\Response
    */
    public function createStatus(Request $request)
    {
        if(Auth::user()->can('employee-status-create')){
            $this->employeeService->createStatus($request);
            return redirect()->back()->with('success','Status created successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified employee status from storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method deleteStatus
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function deleteStatus($id)
    {
        if(Auth::user()->can('employee-status-delete')){
            $this->employeeService->deleteStatus($id);
            return redirect()->back()->with('fail','Status Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Store a newly created grade in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method createGrade
     * @param  \Illuminate\Http\Request  $grade_value
     * @return \Illuminate\Http\Response
    */
    public function createGrade(Request $request)
    {
        if(Auth::user()->can('employee-grade-add')){
            $this->employeeService->createGrade($request);
            return redirect()->back()->with('success','Grade created successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Update the specified resource in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method updateGrade
     * @param  \Illuminate\Http\Request  $request employee_grade_id
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function updateGrade(Request $request, $id)
    {
        if(Auth::user()->can('employee-grade-set')){
            $this->employeeService->updateGrade($request, $id);
            return redirect()->back()->with('success','Grade Updated successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Update the employee archive status (N) by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method employeeArchive
     * @param  \Illuminate\Http\Request  $request employee_all_information
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function employeeArchive(Request $request, $id)
    {
        if(Auth::user()->can('employee-archive')){
            $this->employeeService->employeeArchive($request, $id);
            return redirect()->route('employees.index')->with('fail','Employee Archived Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Store employee edited information in storage by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method editEmployeeInfo
     * @param  int  $request employees_edited_information
     * @return \Illuminate\Http\Response
    */
    public function editEmployeeInfo(Request $request)
    {
        if(Auth::user()->can('employee-profile-edit')){
            $this->employeeService->editEmployeeInfo($request);
            return redirect()->back()->with('success','Profile Update Request Sent successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Display a listing of all employees edit request by directing to employeeService.
     *
     * @author Akash Chandra Debnath
     * @method profileUpdateRequest
     * @param $request void
     * @return \Illuminate\Http\Response
    */
    public function profileUpdateRequest()
    {
        if(Auth::user()->can('dashboard-employee-profileUpdateHistory')){
            $updateRequests = $this->employeeService->profileUpdateRequest();
            return view('profile-update-request', compact('updateRequests'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
