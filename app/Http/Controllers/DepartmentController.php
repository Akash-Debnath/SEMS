<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    /**
     * @var departmentService
     */
    protected $departmentService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }



    /**
     * Display a listing of all departments resource by directing to departmentService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-department')){
            $department = $this->departmentService->getAllDepartment();
            return view('department', compact('department'));
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
     * Store a newly created department resource in storage by directing to departmentService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request department_code
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('department-create')){
            $test = $this->departmentService->createDepartment($request);
            return redirect()->route('department.index')->with('success','Department Added Successfully!');
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
     * Show modal for edit the specified department resource by directing to departmentService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('department-edit')){
            return $this->departmentService->editDepartment($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified department resource in storage by directing to departmentService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request department_code
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->can('department-edit')){
            $this->departmentService->updateDepartment($request);
            return redirect()->route('department.index')->with('success','Department Edited Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified department resource from storage by directing to departmentService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id department_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('department-delete')){
            $this->departmentService->deleteDepartment($id);
            return redirect()->route('department.index')->with('fail','Department Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
