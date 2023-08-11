<?php

namespace App\Http\Controllers;

use App\Services\LeaveGlanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Leave_at_a_glanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $leaveGlanceService;
    public function __construct(LeaveGlanceService $leaveGlanceService)
    {
        $this->LeaveGlanceService = $leaveGlanceService;
    }
    public function index()
    {
        if (Auth::user()->can('dashboard-leave-glance')) {


            $dept = $this->LeaveGlanceService->dept();
            $department = $dept;
            $option = $this->LeaveGlanceService->option();
            $leave_type = $option;
            $year = date('Y');
            $leave = $this->LeaveGlanceService->leave($year);
            return view('leave-glance', compact('dept', 'option', 'leave_type', 'leave', 'department'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    public function search(Request $req)
    {
        if (Auth::user()->can('dashboard-leave-glance')) {
            $year = $req->year;
            $edept = $req->department;
            $department = $this->LeaveGlanceService->dept();
            $type = $req->type;
            $option = $this->LeaveGlanceService->option();
            $leave_type = $option;
            $dept =  $department;
            if (!empty($type)) {

                $leave_type = $this->LeaveGlanceService->leaveByType($req);
            }
            if (!empty($edept)) {

                $dept = $this->LeaveGlanceService->deptBysearch($req);
            }

            $leave = $this->LeaveGlanceService->leave($year);

            return view('leave-glance', compact('leave_type', 'dept', 'option', 'leave', 'department'));
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
