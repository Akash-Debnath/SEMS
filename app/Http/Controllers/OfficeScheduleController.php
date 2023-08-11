<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Option;
use App\Models\Rostering;
use App\Models\RosterSlot;
use App\Models\Employee;
use App\Models\Holyday;
use App\Models\Weekend;
use App\Models\RamadanOfficeTime;
use Illuminate\Http\Request;
use App\Services\OfficeScheduleService;
use Illuminate\Support\Facades\Auth;

class OfficeScheduleController extends Controller
{
    /**
     * @var officeScheduleService
     */
    protected $officeScheduleService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(OfficeScheduleService $officeScheduleService)
    {
        $this->officeScheduleService = $officeScheduleService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getIndex()
    {
        if (Auth::user()->can('dashboard-attendance-officeSchedule')) {
            $employeeDept = $this->officeScheduleService->Department();
            $startdate = strtotime(date('Y-m-01'));
            $enddate = strtotime(date('Y-m-d'));
            $dept = Auth::user()->employeeInfo->dept_code;
            $rosterSlots = $this->officeScheduleService->RosterSlot($dept);
            $emp_id = Auth::user()->employeeInfo->emp_id;

            $roster = false;
            $employee = $this->officeScheduleService->employeeByEmpId($emp_id);
            $defaultWeekend = $this->officeScheduleService->defaultWeekend();
            $defaultTime = $this->officeScheduleService->defaultTime();
            $holiday = $this->officeScheduleService->Holiday();
            $ramadan = RamadanOfficeTime::all();
            if (Auth::user()->employeeInfo->roster == 'Y') {
                $employee = $this->officeScheduleService->employeeBydept($dept);
                $roster = true;
            }

            return view('office-schedules', compact('employeeDept', 'startdate', 'enddate', 'employee', 'roster', 'rosterSlots', 'defaultWeekend', 'defaultTime', 'holiday', 'ramadan'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }

    public function officeSchedule(Request $req)
    {
        if (Auth::user()->can('dashboard-attendance-officeSchedule')) {
            $employeeDept = $this->officeScheduleService->Department();
            $dept = $req->dept_code;
            $startdate = strtotime($req->sdate);
            $enddate = strtotime($req->edate);

            $emp_id = $req->emp_id;
            
            if(!Auth::user()->can('officeSchedule-department-staff-search')){
                $emp_id = Auth::user()->username;               
            }

            $roster = false;
            $emp_rost = $this->officeScheduleService->checkRoster($emp_id);
          
            $rosterSlots = $this->officeScheduleService->RosterSlot($dept);
            $employee = $this->officeScheduleService->employeeByEmpId($emp_id);
            $defaultWeekend = $this->officeScheduleService->defaultWeekend();
            $defaultTime = $this->officeScheduleService->defaultTime();
            $holiday = $this->officeScheduleService->Holiday();
            // $weekend = false;
            $ramadan = RamadanOfficeTime::all();
            if ($emp_rost->roster == 'Y') {
                $employee = $this->officeScheduleService->employeeBydept($dept);
                $roster = true;
            }
            


            return view('office-schedules', compact('employeeDept', 'startdate', 'enddate', 'roster', 'rosterSlots', 'employee', 'defaultWeekend', 'defaultTime', 'holiday', 'ramadan'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
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
