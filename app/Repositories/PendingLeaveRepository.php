<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Option;
use App\Models\Department;
use App\Models\Leave_attachment;
use DateTime;
use Illuminate\Support\Facades\Date;

class PendingLeaveRepository implements RepositoryInterface
{

    public function employee()
    {
        return Employee::where('archive', 'N')->get();
    }

    public function employeeById($id)
    {
        return Employee::where('emp_id', $id)->where('archive', 'N')->get();
    }

    public function dept()
    {
        return Department::all();
    }

    public function approval()
    {
        return Leave::where('m_approved_date', NULL)->where('admin_approve_date', NULL)->where('cancel_req_date', NULL)->orderBy('emp_id', 'asc')->get();
    }

    public function verify()
    {
        return Leave::where('m_approved_date', '!=', NULL)->where('admin_approve_date', NULL)->orderBy('emp_id', 'asc')->get();
    }

    public function cancel()
    {
        return Leave::where('cancel_req_date', '!=', NULL)->get();
    }

    public function option()
    {
        return Option::where('option_name', 'leave_type')->get();
    }

    public function genuity_leaves()
    {
        return Option::where('option_name', 'genuity_leaves_array')->get();
    }

    public function leave_attachment($id)
    {
        return Leave_attachment::where('leave_id', $id)->get();
    }

    public function leave($id)
    {
        return Leave::where('id', $id)->get();
    }

    public function leaveByAV($staff, $year)
    {
        return Leave::where('emp_id', $staff)->whereYear('leave_date', $year)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->get();
    }

    public function Status($eid, $year)
    {
        return Leave::where('emp_id', $eid)->whereYear('leave_start', $year)->where('admin_approve_date', '!=', NULL)->where('m_approved_date', '!=', NULL)->get();
    }


    


    public function updateLeaveRequest($req,$id){
        $leave_type = $req->leave_type;
        $leave_start = $req->from;
        $leave_end = $req->to;
        $leave_date = $leave_end;
        $time_slot  = NULL;
        $date1 = new DateTime($leave_start);
        $date2 = new DateTime($leave_end);
        $period = $date1->diff($date2)->days;
        $file = $req->filename;

        if ($leave_type == 'HL') {
            $leave_date = $req->date;
            $leave_start = $leave_date;
            $leave_end = $leave_date;
            $time_slot = $req->time_slot;
        }


        $data = array(

            'leave_start' => $leave_start,
            'leave_end' => $leave_end, 'leave_date' => $leave_date, 'time_slot' => $time_slot, 'leave_type' => $leave_type, 'period' => $period, 'address_d_l'=>$req->address_d_l, 'special_reason' => $req->specialReason
        );
       Leave::where('id', $id)->update($data);
       $i = 0;
        if (!is_null($file)) {
            for ($i = 0; $i < count($file); $i++) {
                $f = $file[$i];
                $f->move('leave_attachments/', $f->getClientOriginalName());

                $attdata = array('original_file_name' => $f->getClientOriginalName());
                $attdata1 = array('leave_id' => $id, 'original_file_name' => $f->getClientOriginalName());

                $check_d = Leave_attachment::where('leave_id', $id)->count();
                if ($check_d > 0) {
                    Leave_attachment::where('leave_id', $id)->update($attdata);
                } else {
                    Leave_attachment::create($attdata1);
                }

                $i = $i + 1;
            }
        }
        return;
    }





    public function Leave_Verify($req, $id)
    {
        $ls = $req->ls;


        $admin_id = Auth::user()->employeeInfo->emp_id;

        $v = $req->v1;
        if ($v == 'V') {
            $admin_approve_date = date('Y-m-d');
            $cancel_approve_date = NULL;
            $a_remark = $req->a_remark;
        } elseif ($v == 'R') {
            $admin_approve_date = NULL;
            $cancel_approve_date = date('Y-m-d');
            $a_remark = $req->a1_remark;
        }

        $data = array(
            'admin_approve_date' => $admin_approve_date,
            'admin_remark' => $a_remark,
            'admin_id' => $admin_id,
            'cancel_approve_date' => $cancel_approve_date
        );

        return Leave::where('id', $id)->update($data);
    }

    public function cancel_req($req, $id)
    {
        $cancel_req_date = Date('Y-m-d');

        $data = array('cancel_req_date' => $cancel_req_date);

        return Leave::where('id', $id)->update($data);
    }

    public function cancel_approve($req, $id)
    {
        $cancel_approve_date = Date('Y-m-d');

        $data = array('cancel_approve_date' => $cancel_approve_date);


        return Leave::where('id', $id)->update($data);
    }



    public function carryForwardLeave($id, $newYear)
    {
        return Leave::where('emp_id', $id)->whereYear('leave_start', $newYear)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->where('leave_type', 'AL')->get();
    }

    public function deleteLeave($id)
    {
        return Leave::where('id', $id)->delete();
    }

    public function LeaveApprovalViaComment($req, $id)
    {
        $ls = $req->ls;


        $manager_id = Auth::user()->employeeInfo->emp_id;
        $comment1 = $req->comment1;
        $comment2 = $req->comment2;
        $comment3 = $req->comment3;
        $a = $req->a1;
        if ($a == 'A') {
            $m_approve_date = date('Y-m-d');
            $cancel_req_date = NULL;
            $m_remark = $req->m_remark;
        } elseif ($a == 'R') {
            $m_approve_date = NULL;
            $cancel_req_date = date('Y-m-d');
            $m_remark = $req->m1_remark;
        }

        $data = array(
            'm_approved_date' => $m_approve_date,
            'manager_remark' => $m_remark,
            'comment1' => $comment1,
            'comment2' => $comment2,
            'comment3' => $comment3,
            'manager_id' => $manager_id,
            'cancel_req_date' => $cancel_req_date
        );


        return Leave::where('id', $id)->update($data);;
    }

    public function all()
    {
        return true;
    }


    public function get($id)
    {
        return true;
    }



    public function create($data)
    {
    }



    public function update(array $data, $id)
    {
        return Leave::where('id', $id)->update($data);
    }



    public function delete($id)
    {
        return true;
    }
}
