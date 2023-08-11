<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Option;
use App\Models\Leave;
use App\Models\Leave_attachment;
use App\Models\Employee;
use DateTime;

class LeaveRequestRepository implements RepositoryInterface
{

    public function employee()
    {
        return Employee::where('archive', 'N')->get();
    }

    public function option()
    {
        return Option::where('option_name', 'leave_type')->get();
    }

    public function genLeave()
    {
        return Option::where('option_name', 'genuity_leaves_array')->get();
    }

    public function create_req($req)
    {
        $leave_type = $req->leave_type;
        $from = $req->from;
        $to = $req->to;
        $date = $req->date;
        $time_slot = $req->time_slot;
        $address_d_l = $req->address_d_l;
        $special_reason = $req->special_leave;
        $date1 = new DateTime($from);
        $date2 = new DateTime($to);
        $period = $date1->diff($date2)->days;
        $emp_id = Auth::user()->employeeInfo->emp_id;

        if ($leave_type == 'HL') {
            $from = new DateTime();
            $to = new DateTime();
        }

        $data = array(
            'leave_type' => $leave_type,
            'leave_start' => $from,
            'leave_end' => $to,
            'leave_date' => $date,
            'time_slot' => $time_slot,
            'address_d_l' => $address_d_l,
            'special_reason' => $special_reason,
            'period' => $period,
            'emp_id' => $emp_id,
        );

        return Leave::create($data);
    }

    public function leaveAttachment($req)
    {
        $file = $req->filename;
        $emp_id = Auth::user()->employeeInfo->emp_id;
        $lastLeave = Leave::where('emp_id', $emp_id)->orderBy('created_at', 'desc')->first();
        $ldata = array();

        $i = 0;
        if (!is_null($file)) {
            for ($i = 0; $i < count($file); $i++) {
                $extenstion = $file[$i]->getClientOriginalExtension();
                if (strtoupper($extenstion) == "PDF") {
                    $filename = $file[$i]->getClientOriginalName();
                    $file[$i]->move('leave_attachments/', $filename);
                    $ldata = array('leave_id' => ($lastLeave->id), 'original_file_name' => $filename);
                    Leave_attachment::create($ldata);
                } else {
                    return redirect()->back()->with('Fail', "Wrong file format! Only text file is acceptable.");
                }
            }
        }
    }


    public function carryForwardLeave($eid, $newYear)
    {
        return Leave::where('emp_id', $eid)->whereYear('leave_start', $newYear)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->where('leave_type', 'AL')->get();
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
        return true;
    }



    public function delete($id)
    {
        return true;
    }
}
