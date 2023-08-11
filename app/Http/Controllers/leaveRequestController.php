<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Leave;
use App\Models\Leave_attachment;
use App\Models\Employee;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Services\LeaveRequestService;

class leaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $leaveRequestService;
    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->LeaveRequestService = $leaveRequestService;
    }
    public function index()
    {
        $year = date('Y');
        $today = ('Y-m-d');
        $ls = "";
        $employee = $this->LeaveRequestService->employee();
        $eid = Auth::user()->employeeInfo->emp_id;
        $id = "";
        $year = date('Y');
        $date = strtotime($year . ' -1 year');
        $newYear = date('Y', $date);
        $option = $this->LeaveRequestService->option();
        $leave = Leave::where('emp_id', $eid)->where('leave_start', $today)->get();
        $status = Leave::where('emp_id', $eid)->whereYear('leave_start', $year)->get();
        $genuity_leaves = $this->LeaveRequestService->genLeave();
        $carry = $this->LeaveRequestService->carryForwardLeave($eid, $newYear);
        return view('send-leave-request', compact('option', 'leave', 'genuity_leaves', 'eid', 'id', 'employee', 'ls', 'status', 'year', 'carry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        if (Auth::user()->can('leave-request')) {

            $leave_req =  $this->LeaveRequestService->create_req($req);
            $leave_att =  $this->LeaveRequestService->leaveAttachment($req);

            return redirect('leave-list')->with('successfull', "uploaded successfully !!!");
        }else{ 
            
            return redirect()->route('noAccess');
        }
    }

    // leave-request----from new

    public function showForm()
    {
        if (Auth::user()->can('leave-request')) {
            $year = date('Y');
            $today = ('Y-m-d');
            $ls = "";
            $employee = $this->LeaveRequestService->employee();
            $eid = Auth::user()->employeeInfo->emp_id;
            $id = "";
            $year = date('Y');
            $date = strtotime($year . ' -1 year');
            $newYear = date('Y', $date);
            $option = $this->LeaveRequestService->option();
            $leave = Leave::where('emp_id', $eid)->where('leave_start', $today)->get();
            $status = Leave::where('emp_id', $eid)->whereYear('leave_start', $year)->get();
            $genuity_leaves = $this->LeaveRequestService->genLeave();
            $carry = $this->LeaveRequestService->carryForwardLeave($eid, $newYear);
            return view('leave-request-form', compact('option', 'leave', 'genuity_leaves', 'eid', 'id', 'employee', 'ls', 'status', 'year', 'carry'));
        } else {

            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


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
