<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdministratorPrivilegeService;
use Illuminate\Support\Facades\Auth;

class AdministratorPrivilegeController extends Controller
{

    /**
     * @var administratorPrivilegeService
    */
    protected $administratorPrivilegeService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(AdministratorPrivilegeService $administratorPrivilegeService)
    {
        $this->administratorPrivilegeService = $administratorPrivilegeService;
    }



    /**
     * Display a listing of privilegers (manager, roster, admin, management) by directing to administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-administratorPrivilege')){
            $employees = $this->administratorPrivilegeService->getAllEmployee();
            $privileger = $this->administratorPrivilegeService->getAllPrivileger();
            $departments = $this->administratorPrivilegeService->getAllDepartment();
            return view('administrator_privilege', compact('employees', 'privileger', 'departments'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
     * Store a newly created manager level privileger in storage by redirecting to administratorPrivilegeService by directing to administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request $request employee_id, department_code, role_type
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('privilege-create')){
            $this->administratorPrivilegeService->addPrivileger($request);
            return redirect()->back()->with('success', 'Administrator Privileger Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified manager level privileger from storage by administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id privileger_id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('privilege-delete')){
            $this->administratorPrivilegeService->deleteManager($id);
            return redirect()->back()->with('fail','Manager Privileger Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    /**
     * Store a newly created admin level privileger in storage by redirecting to administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method adminPrivilege
     * @param  \Illuminate\Http\Request  $request employee_id, department_code, role_type
     * @return \Illuminate\Http\Response
    */
    public function adminPrivilege(Request $request)
    {
        if(Auth::user()->can('privilege-create')){
            $this->administratorPrivilegeService->adminPrivilege($request);
            return redirect()->back()->with('success', 'Administrator Privileger Added Successfully');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    /**
     * Store a newly created roster level privileger in storage by redirecting to administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method rosterPrivilege
     * @param  \Illuminate\Http\Request  $request employee_id, department_code, role_type
     * @return \Illuminate\Http\Response
    */
    public function rosterPrivilege(Request $request)
    {
        if(Auth::user()->can('privilege-create')){
            $this->administratorPrivilegeService->rosterPrivilege($request);
            return redirect()->back()->with('success', 'Administrator Privileger Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }



    /**
     * Store a newly created management level privileger in storage by redirecting to administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method managementPrivilege
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function managementPrivilege(Request $request)
    {
        if(Auth::user()->can('privilege-create')){
            $this->administratorPrivilegeService->managementPrivilege($request);
            return redirect()->back()->with('success', 'Administrator Privileger Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    

    /**
     * Remove the specified admin level privileger from storage by administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method deleteAdmin
     * @param  int  $id privileger_id
     * @return \Illuminate\Http\Response
    */
    public function deleteAdmin($id)
    {
        if(Auth::user()->can('privilege-delete')){
            $this->administratorPrivilegeService->deleteAdmin($id);
            return redirect()->back()->with('fail','Admin Privileger Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }



    /**
     * Remove the specified roster level privileger from storage by administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method deleteRoster
     * @param  int  $id privileger_id
     * @return \Illuminate\Http\Response
    */
    public function deleteRoster($id)
    {
        if(Auth::user()->can('privilege-delete')){
            $this->administratorPrivilegeService->deleteRoster($id);
            return redirect()->back()->with('fail','Roster Privileger Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }




    /**
     * Remove the specified management level privileger from storage by administratorPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method deleteManagement
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function deleteManagement($id)
    {
        if(Auth::user()->can('privilege-delete')){
            $this->administratorPrivilegeService->deleteManagement($id);
            return redirect()->back()->with('fail','Management Privileger Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }
}
