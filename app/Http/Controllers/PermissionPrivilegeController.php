<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionPrivilegeService;
use Illuminate\Support\Facades\Auth;

class PermissionPrivilegeController extends Controller
{

    /**
     * @var permissionPrivilegeService
     */
    protected $permissionPrivilegeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(PermissionPrivilegeService $permissionPrivilegeService)
    {
        $this->permissionPrivilegeService = $permissionPrivilegeService;
    }


    /**
     * Display the form of permissions privilege resource by directing to permissionPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @param void
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-permissionPrivilege')){
            $activity = $this->permissionPrivilegeService->getAllActivity();
            $employees = $this->permissionPrivilegeService->getAllEmployee();
            $departments = $this->permissionPrivilegeService->getAllDepartment();
            return view('permission-privilege-setting', compact('activity', 'employees', 'departments'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
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
     * Store a newly created permission privilege resource in storage by directing to permissionPrivilegeService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('permissionPrivilege-create')){
            $this->permissionPrivilegeService->createPermission($request);
            return redirect()->back()->with('Permission added to selected employee Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
