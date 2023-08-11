<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DesignationService;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{

    /**
     * @var designationService
     */
    protected $designationService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }


    /**
     * Display a listing of all desigantion resource by directing to designationService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-designation')){
            $designation = $this->designationService->getAllDesignation();
            $department = $this->designationService->getEmployeeDepartment();
            $deptCode = request()->query()['dept']??null;
            return view('designation', compact('designation','department','deptCode'));
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
     * Store a newly created designation resource in storage .
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request department, designation_name
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('designation-create')){
            $this->designationService->createDesignation($request);
            return redirect()->back()->with('success','Designation Added Successfully!');
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
     * Show the form for editing the specified designation resource .
     *
     * @author Akash Chandra Debnath
     * @mathod edit
     * @param  int  $id designation_id 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('designation-edit')){
            return $this->designationService->editDesignation($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @author AKash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request department, designation_name
     * @param  id $id 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->can('designation-edit')){
            $this->designationService->updateDesignation($request);
            return redirect()->route('designation.index')->with('success','Designation Edited Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified designation resource from storage .
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id designation_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('designation-delete')){
            $this->designationService->deleteDesignation($id);
            return redirect()->back()->with('fail','Desigantion Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
