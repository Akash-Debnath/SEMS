<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Missing_attendance;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Iorecords;
use App\Models\Iorecords_temp;
use App\Models\Holyday;
use App\Models\Weekend;
use App\Models\Option;
use App\Models\Leave;
use App\Models\Rostering;
use App\Models\Roster_slot;
use App\Models\Incident;
use App\Models\Ramadan_office_time;
use App\Models\EmployeeRosterSchedule;
use App\Models\Roster_holiday;
use Illuminate\Support\Facades\Auth;
use DateTime;

class Missing_attendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // missing-attendance-requests
    public function index()
    {
        $employee = Employee::where('archive', 'N')->get();
        $approve = Missing_attendance::where('m_approved_date', NULL)->where('a_verified_date', NULL)->get();
        $verify = Missing_attendance::where('m_approved_date', '!=',NULL)->where('a_verified_date', NULL)->get();
        return view('missing-attendance-req', compact('approve', 'verify', 'employee'));
    }
// approve attendance req
    public function approve_att_req($id)
    {
        $get = Missing_attendance::where('id', $id)->get();
        foreach ($get as $g) {
            $in = $g->in;
            $date = date('Y-m-d');
            $manager_id = Auth::user()->employeeInfo->emp_id;
            $data = array('m_approved_date'=> $date,'manager_id'=>$manager_id);
            $update = Missing_attendance::where('id',$id)->update($data);
            
            
        }
      
        return redirect('missing-attendance-req');
    }

    // verify attendance req
    public function verify_att_req($id)
    {
        $get = Missing_attendance::where('id', $id)->get();
        foreach ($get as $g) {
            $in = $g->in;
            $date = date('Y-m-d');
            $admin_id = Auth::user()->employeeInfo->emp_id;
            $data = array('a_verified_date'=> $date,'admin_id'=>$admin_id);
            $add_att = array('emp_id'=>$g->emp_id,'stime'=>$g->in,'etime'=>$g->out, 'date'=>$g->date);
            $update = Missing_attendance::where('id',$id)->update($data);
            $iorecord = new Iorecords_temp;
            $insert = Iorecords_temp::create($add_att);
            
        }
      
        return redirect('missing-attendance-req');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // upload---------------------------------------------
    public function upload_Attendance()
    {
        $dept = Department::all();
        $employee = Employee::where('archive', 'N')->get();
        return view('upload-attendance-info', compact('dept', 'employee'));
    }


    public function attendance_file(Request $req)
    {
        if ($req->hasfile('file')) {
            $file = $req->file('file');
            $extenstion = $file->getClientOriginalExtension();
            if(strtoupper($extenstion)=="TXT")
            {
                $filename = time() . '.' . $extenstion;
                $file->move('attendance_files/', $filename);
                $req->file = $filename;
    
                $url="attendance_files/" . $filename;
                $string=file_get_contents($url);
                $a=['"','\n'];
                $b=['',''];
                $strreplace=str_replace($a,$b,$string);
                file_put_contents($url,$strreplace);
    
                $file = fopen("attendance_files/" . $filename, "r");
                
                while (!feof($file)) {
                    $content = fgets($file);
                    $carray = explode(",", $content);
                    if(count($carray)<9) continue;
                    list($sl, $card, $emp_id, $uname, $date, $time, $terminal, $inout, $door) = $carray;
                    $data = array('emp_id' => $emp_id, 'stime' => $time, 'date' => $date);
                    $attendance = new Iorecords;
                    $insert = Iorecords::create($data);
                }
            }else {
                return redirect()->back()->with('Fail', "Wrong file format! Only text file is acceptable.");
            }
        }
        return redirect('upload');
    }


    public function training_attendance(Request $req)
    {

        if ($req->hasfile('training_file')) {
            $file = $req->file('training_file');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            if(strtoupper($extenstion)=="TXT")
            {
                $file->move('training_attendance_files/', $filename);
                $req->training_file = $filename;
                
                $url="training_attendance_files/" . $filename;
                $string=file_get_contents($url);
                $a=['"','\n'];
                $b=['',''];
                $strreplace=str_replace($a,$b,$string);
                file_put_contents($url,$strreplace);
                
                $file = fopen("training_attendance_files/" . $filename, "r");

                while (!feof($file)) {
                    $content = fgets($file);
                    $carray = explode(",", $content);
                    if(count($carray)<9) continue;
                    list($sl, $card, $emp_id, $uname, $date, $time, $terminal, $inout, $door) = $carray;
                    $data = array('emp_id' => $emp_id, 'stime' => $time, 'date' => $date);
                    $attendance = new Iorecords_temp;
                    $insert = Iorecords_temp::create($data);
                }
            }else {
                return redirect()->back()->with('Fail', "Wrong file format! Only text file is acceptable.");
            }
        }
        return redirect('upload');
    }

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
        $reason = $request->reason;
        $dept = $request->dept;
        $staff = $request->staff;
        $date = $request->date;
        $in = $request->in;
        $out = $request->out;


        $data = array('emp_id' => $request->staff, 'date' => $request->date, 'in' => $request->in, 'out' => $request->out, 'reason' => $request->reason, 'status' => 'p');
        //    dd($data);


        //re
        $check_d = Missing_attendance::where('emp_id', $staff)->where('date', $date)->get();

        if (count($check_d) > 0) {
            echo '<script>alert("once");</script>';
        } elseif (count($check_d) == 0) {
            $upload = Missing_attendance::create($data);
            return redirect('upload-attendance');
        }

        //    return redirect()->targetUrl('upload-attendance');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function report()
    {
        $from = date('Y-m-01');
        $start = strtotime($from);
        $to = date('Y-m-d');
        $end = strtotime($to);
        $date = new DateTime('m');
        $report = Iorecords_temp::where('emp_id', '273')->get();
        $dept = Department::all();
        $employee = Employee::where('archive', 'N')->get();
        $holiday = Holyday::all();
        $staff = '273';
        $weekend = Weekend::where('emp_id',$staff)->get();
        
        $roster_dept = Option::where('option_name','roster_dept')->get();
        $default_weekend = Option::where('option_name','default_weekend')->get();
        // $roster_slot= Roster_slot::all();
        // $edept=Auth::user()->employeeInfo->dept_code;
        $edept='SY';
        $leave = Leave::where('emp_id',$staff)->get();
        $rostering = Rostering::where('emp_id',$staff)->get();
        $default_time = Option::where('option_name','default_time')->get();
        $incident = Incident::all();
        $ramadan = Ramadan_office_time::all();
        $emp_roster_schedule=EmployeeRosterSchedule::where('emp_id',$staff)->get();
        $roster_holiday = Roster_holiday::where('emp_id',$staff)->get();
        return view('report', compact('roster_holiday','emp_roster_schedule','ramadan','incident','default_time','rostering','default_weekend','roster_dept','edept','dept', 'employee', 'report', 'start', 'end', 'holiday', 'weekend', 'staff','leave','from','to'));
    }

    public function search_report(Request $req)
    {
        $dept = Department::all();
        $staff = $req->staff;
        $employee = Employee::where('archive', 'N')->get();
        $holiday = Holyday::all();
        $from = $req->from;
        $start = strtotime($from);
        $to = $req->to;
        $end = strtotime($to);
        $report = Iorecords_temp::where('date', '<=', $to)->where('date', '>=', $from)->where('emp_id', $staff)->get();
        $weekend = Weekend::where('emp_id',$staff)->get();
        $edept=$req->dept;
        $roster_dept = Option::where('option_name','roster_dept')->get();
        $default_weekend = Option::where('option_name','default_weekend')->get();
        // $roster_slot= Roster_slot::all();
        $leave = Leave::where('emp_id',$staff)->get();
        $rostering = Rostering::where('emp_id',$staff)->get();
        $default_time = Option::where('option_name','default_time')->get();
        $incident = Incident::all();
        $ramadan = Ramadan_office_time::all();
        $emp_roster_schedule=EmployeeRosterSchedule::where('emp_id',$staff)->get();
        $roster_holiday = Roster_holiday::where('emp_id',$staff)->get();
        return view('report', compact('roster_holiday','emp_roster_schedule','ramadan','incident','default_time','rostering','default_weekend','roster_dept','edept','staff', 'report', 'employee', 'dept', 'start', 'end', 'holiday', 'weekend','leave','from','to'));
    }


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
