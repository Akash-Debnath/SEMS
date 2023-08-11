<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArchiveService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Route;

class ArchiveController extends Controller
{
    /**
     * @var archiveService
     */
    protected $archiveService;
    protected $employeeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(ArchiveService $archiveService, EmployeeService $employeeService)
    {
        $this->archiveService = $archiveService;
        $this->employeeService = $employeeService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $employees= $this->archiveService->getAllArchiveEmployee();
        return view('archive-employee', compact('employees'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empInfo = $this->archiveService->getEmployeeInfo($id);
        $facility = $this->employeeService->getAllFacility();
        $faci = $this->employeeService->getFacility($id);
        $stat = $this->employeeService->getStatus($id);
        $employeeGrade= $this->employeeService->getEmployeeGrade();
        return view('employee-details',compact('empInfo', 'facility', 'faci', 'stat', 'employeeGrade'));
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
