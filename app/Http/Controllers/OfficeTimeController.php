<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfficeTimeService;
use Illuminate\Support\Facades\Auth;

class OfficeTimeController extends Controller
{

    /**
     * @var officeTimeService
    */
    protected $officeTimeService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(OfficeTimeService $officeTimeService)
    {
        $this->officeTimeService = $officeTimeService;
    }


    /**
     * Display a listing of the office time resource by directing to officeTimeService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-officeTime')){
            $employees = $this->officeTimeService->getAllEmployee();
            $weekleaves = $this->officeTimeService->getAllWeekLeaves();
            $departments = $this->officeTimeService->getAllDepartment();
            return view('officeTime', compact('employees', 'weekleaves', 'departments'));
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


    /**
     * Update the specified employee office time scheduling resource by directing to officeTimeService.
     *
     * @author Akash Chandra Debnath
     * @method updateSchedule
     * @param $request schedule_status (Yes/No)
     * @return \Illuminate\Http\Response
    */
    public function updateSchedule(Request $request, $id)
    {
        if(Auth::user()->can('schedule-update')){
            $this->officeTimeService->updateSchedule($request, $id);
            return redirect()->back()->with('success','Schedule updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Update the specified employee office time roster status resource by directing to officeTimeService.
     *
     * @author Akash Chandra Debnath
     * @method updateRoster
     * @param $request roster_status (Yes/No)
     * @return \Illuminate\Http\Response
    */
    public function updateRoster(Request $request, $id)
    {
        if(Auth::user()->can('roster-update')){
            $this->officeTimeService->updateRoster($request, $id);
            return redirect()->back()->with('success','Roster updated!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
