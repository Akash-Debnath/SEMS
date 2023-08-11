<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Services\PendingLeaveService;
use Illuminate\Support\Facades\Auth;


class pendingLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PendingLeaveService $pendingLeaveservice)
    {
        $this->PendingLeaveservice = $pendingLeaveservice;
    }
    public function index()
    {
        if (Auth::user()->can('leave-approval-approve-refuse') || Auth::user()->can('leave-verification-verify-refuse')) {
            $employee =  $this->PendingLeaveservice->employee();
            $approval = $this->PendingLeaveservice->approval();
            $verify = $this->PendingLeaveservice->verify();
            $cancel = $this->PendingLeaveservice->cancel();
            $option = $this->PendingLeaveservice->option();

            return view('pending-leave', compact('approval', 'verify', 'employee', 'cancel', 'option'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through that page');
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

    //  view leave to leave-req
    public function show($eid, $id, $date)
    {
        // $date=date('2019');
        // $now = strtotime($date);
        if (Auth::user()->can('leave-view') || Auth::user()->can('leave-cancel')) {
            $id = $id;
            $ls = "";
            $date = $date;
            $year = date('Y', strtotime($date));
            $date = strtotime($year . ' -1 year');
            $newYear = date('Y', $date);
            $employee = $this->PendingLeaveservice->employee();
            $leave =  $this->PendingLeaveservice->leave($id);
            $status = $this->PendingLeaveservice->Status($eid, $year);
            $genuity_leaves = $this->PendingLeaveservice->genuity_leaves();
            $option = $this->PendingLeaveservice->option();
            $l_att = $this->PendingLeaveservice->leave_attachment($id);
            $carry = $this->PendingLeaveservice->carryForwardLeave($eid, $newYear);
            return view('leave-request-form', compact('leave', 'option', 'id', 'eid', 'genuity_leaves', 'employee', 'date', 'ls', 'status', 'year', 'l_att', 'carry'));
        } else {
            return redirect()->back()->with('fail', 'You cant enter here');
        }
    }


    //  view leave to leave-req
    public function editLeave($eid, $id, $date)
    {
        if (Auth::user()->can('leave-edit')) {
            if ($eid == Auth::user()->employeeInfo->emp_id) {
                $id = $id;
                $ls = "";
                $date = $date;
                $year = date('Y', strtotime($date));
                $date = strtotime($year . ' -1 year');
                $newYear = date('Y', $date);
                $employee = $this->PendingLeaveservice->employee();
                $leave =  $this->PendingLeaveservice->leave($id);
                // $leave = Leave::where('id',$id)->first();
                $status = $this->PendingLeaveservice->Status($eid, $year);
                $genuity_leaves = $this->PendingLeaveservice->genuity_leaves();
                $option = $this->PendingLeaveservice->option();
                $carry = $this->PendingLeaveservice->carryForwardLeave($eid, $newYear);
                return view('leave-request-form', compact('leave', 'option', 'id', 'eid', 'genuity_leaves', 'employee', 'date', 'ls', 'status', 'year', 'carry'));
            } else {

                return redirect('/view-leave/' . $eid . '/' . $id . '/' . $date);
            }
        } else {
            return redirect()->back()->with('fail', 'You cant enter here');
        }
    }


    public function updateLeaveRequest(Request $req, $id)
    {
        $this->PendingLeaveservice->updateLeaveRequest($req, $id);
        return redirect('leave-list');
    }


    // update leave -req

    public function update_req(Request $req, $id)
    {
        $this->PendingLeaveservice->updateLeaveRequest($req, $id);

        // dd($id);

        return redirect('leave-list');
    }

    // show leave to leave-list

    public function showLeaves($id, $date)
    {
        if (Auth::user()->can('view-leave-list')) {
            $year = date('Y', strtotime($date));
            //ca
            $date = strtotime($year . ' -1 year');
            $newYear = date('Y', $date);
            // ---ca
            $staff = $id;
            $getEmp = Employee::where('emp_id', $id)->first();

            $department = $getEmp->dept_code;
            $option = $this->PendingLeaveservice->option();
            $genuity_leaves = $this->PendingLeaveservice->genuity_leaves();
            $employee = $this->PendingLeaveservice->employeeById($id);
            $leave = $this->PendingLeaveservice->leaveByAV($staff, $year);
            $dept = $this->PendingLeaveservice->dept();
            $carry = $this->PendingLeaveservice->carryForwardLeave($id, $newYear);
            return view('leave-list', compact('leave', 'dept', 'year', 'employee', 'option', 'genuity_leaves', 'staff', 'carry', 'department'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to through this page');
        }
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
    public function update(Request $req, $id)
    {

        if (Auth::user()->can('leave-approval-approve-refuse')) {
            $this->PendingLeaveservice->LeaveApprovalViaComment($req, $id);
            return redirect('pending-leave');
        } else {
            return redirect()->route('noAccess');
        }
    }


    public function Leave_Verify(Request $req, $id)
    {
        if (Auth::user()->can('leave-verification-verify-refuse')) {
            $approve = $this->PendingLeaveservice->Leave_Verify($req, $id);

            return redirect('pending-leave');
        } else {
            return redirect()->route('noAccess');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function cancel_req(Request $req, $id)
    {
        $cancel_req = $this->PendingLeaveservice->cancel_req($req, $id);
        return redirect('leave-list');
    }

    public function cancel_approve(Request $req, $id)
    {

        $cancel_req = $this->PendingLeaveservice->cancel_approve($req, $id);
        return redirect('leave-list');
    }

    public function deleteLeave($id)
    {
        if (Auth::user()->can('leave-delete')) {
            $delete = $this->PendingLeaveservice->deleteLeave($id);
            return redirect('leave-list');
        } else {
            return redirect('leave-list');
        }
    }
    public function destroy($id)
    {
        //
    }
}
