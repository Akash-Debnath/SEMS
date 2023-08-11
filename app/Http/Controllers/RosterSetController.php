<?php

namespace App\Http\Controllers;

use App\Models\Rostering;
use Illuminate\Http\Request;
use App\Services\RosterSetService;
use Illuminate\Support\Facades\Auth;

class RosterSetController extends Controller
{

    /**
     * @var rosterSetService
     */
    protected $rosterSetService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RosterSetService $rosterSetService)
    {
        $this->rosterSetService = $rosterSetService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    /**
     * Display roster settings module resources by directing to rosterSetService
     * 
     * @author Akash Chandra Debnath
     * @method setRoster
     * @param $request department_code, roster_status
     * @return response
    */
    public function setRoster(Request $request)
    {
        if(Auth::user()->can('dashboard-attendance-rosterSet')){
            $employees = $this->rosterSetService->getAllEmployee($request);
            $departments = $this->rosterSetService->getAllDepartment();
            $rosterSlot = $this->rosterSetService->getAllSlot($request);
            $rosterDepartment = $this->rosterSetService->getRosterDepartment($request);
            $startdate = strtotime($request->from);
            $enddate = strtotime($request->to);
            $startdateSearch = $request->from;
            $enddateSearch = $request->to;
            $roster = $request->roster;
            $dept = $request->dept_code;
            return view('set-roster', compact('departments', 'employees', 'rosterSlot', 'rosterDepartment', 'startdate', 'enddate', 'startdateSearch', 'enddateSearch', 'roster', 'dept'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Store all roster employees resources by directing to rosterSetService [Same Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterSameTime
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days.
     * @return response
    */
    public function setRosterSameTime(Request $request)
    {
        if(Auth::user()->can('rosterSettings-create')){
            $this->rosterSetService->setRosterSameTime($request);
            return redirect()->back()->with('success', 'Roster Settings Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Store all roster employees resources by directing to rosterSetService [Same Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterMoreWeekend
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days, reason_for_extra_weekend.
     * @return response
    */
    public function setRosterMoreWeekend(Request $request)
    {
        if(Auth::user()->can('rosterSettings-create')){
            $this->rosterSetService->setRosterMoreWeekend($request);
            return redirect()->back()->with('success', 'Roster Settings Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Store all roster employees resources by directing to rosterSetService [Custom Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterCustomTime
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days.
     * @return response
    */
    public function setRosterCustomTime(Request $request)
    {
        if(Auth::user()->can('rosterSettings-create')){
            if($request->customReason == null){
                $this->rosterSetService->setRosterCustomTime($request);
            } else{
                $this->rosterSetService->setRosterCustomMoreWeekend($request);
            }
            return redirect()->back()->with('success', 'Roster Settings Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Store data of slotted employee data by directing to rosterSetService [Slot]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterSlotData
     * @param $request employee_id,weekend_employees_id,dates,slotNo
     * @return void
    */
    public function setRosterSlotData(Request $request)
    {
        if(Auth::user()->can('rosterSettings-create')){
            $this->rosterSetService->setRosterSlotData($request);
            return redirect()->back()->with('success', 'Roster Settings Added Successfully!');
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
     * Store a newly created slot data in storage by directing to rosterSetService.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('rosterSettings-create')){
            $this->rosterSetService->addNewRosterSlot($request);
            return redirect()->back()->with('success', 'Roster Slot Added Successfully!');
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
     * Update slot and store in storage by redirecting to rosterSetService.
     *
     * @author Akash Chnadra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request
     * @param  $request slot_number, slot_start_time, slot_end_time, $id Slot_id in DB
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('rosterSettings-edit')){
            $this->rosterSetService->updateRosterSlot($request, $id);
            return redirect()->back()->with('success', 'Roster Slot Updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the slot by the requested $id with redirecting to rosterSetService
     *
     * @author Akash Chandra Debnath
     * @param  $id slot_id  
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('rosterSettings-delete')){
            $this->rosterSetService->deleteRosterSlot($id);
            return redirect()->back()->with('fail', 'Roster Slot Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
