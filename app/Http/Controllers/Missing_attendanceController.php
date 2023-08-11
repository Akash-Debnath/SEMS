<?php

namespace App\Http\Controllers;

use App\Services\Missing_attendanceService;
use Illuminate\Http\Request;
use App\Models\Iorecords;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use DateTime;

class Missing_attendanceController extends Controller
{

    protected $missing_attendanceService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // missing-attendance-requests

    public function __construct(Missing_attendanceService $missing_attendanceService)
    {
        $this->Missing_attendanceService = $missing_attendanceService;
    }

    public function index()
    {
        if (Auth::user()->can('dashboard-attendance-missingAttendanceRequest')) {
            $employee = $this->Missing_attendanceService->get_employee();
            $approve = $this->Missing_attendanceService->approve();
            $verify = $this->Missing_attendanceService->verify();
            return view('missing-attendance-req', compact('approve', 'verify', 'employee'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }


    /**
     * For verify missing attendance
     * 
     * @Modified by Akash Chandra Debnath [!author]
     * @todo refactor code and proper name convention 
     */
    public function approve_att_req($id)
    {
        if (Auth::user()->can('missing-attendance-approval-approve-refuse')) {
            $get = $this->Missing_attendanceService->get_Missing_id($id);
            foreach ($get as $g) {

                $update = $this->Missing_attendanceService->update_Missing_id($id);
            }
            return redirect()->back()->with('success', 'Attendance Request Approved');
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }


    /**
     * For verify missing attendance
     * 
     * @Modified by Akash Chandra Debnath [!author]
     * @todo refactor code and proper name convention 
     */
    public function verify_att_req($id)
    {
        if (Auth::user()->can('missing-attendance-verification-approve-refuse')) {
            $get = $this->Missing_attendanceService->get_Missing_id($id);
            foreach ($get as $g) {
                $in = $g->in;
                $date = date('Y-m-d');
                $admin_id = Auth::user()->employeeInfo->emp_id;
                $data = array('a_verified_date' => $date, 'admin_id' => $admin_id);
                $add_att = array('emp_id' => $g->emp_id, 'stime' => $g->in, 'etime' => $g->out, 'date' => $g->date);
                $update = $this->Missing_attendanceService->update_verified_missing_att($id);
                $insert = $this->Missing_attendanceService->add_att($add_att);
            }

            return redirect()->back()->with('success', 'Attendance Verified Successfully');
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // upload---------------------------------------------
    public function upload_Attendance()
    {
        if (Auth::user()->can('dashboard-attendance-upload')) {
            $dept = $this->Missing_attendanceService->get_dept();
            $employee = $this->Missing_attendanceService->get_employee();

            return view('upload-attendance-info', compact('dept', 'employee'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }

    public function getAttendanceByUrl()
    {

        // $path = "../attendance_files";

        // $handle = opendir($path);
        // $fileArray = array();
        // while($file=readdir($handle)){
        //   array_push( $fileArray,$file);
        // }

        // closedir($handle);


        // foreach($fileArray as $fa){
        $fa = date('mdy') . ".txt";
        $url = "../attendance_files/" . $fa;
        $string = file_get_contents($url);
        $a = ['"', '\n'];
        $b = ['', ''];
        $strreplace = str_replace($a, $b, $string);
        file_put_contents($url, $strreplace);

        $file = fopen("../attendance_files/" . $fa, "r");
        while (!feof($file)) {
            $content = fgets($file);
            $carray = explode(",", $content);
            if (count($carray) < 9) continue;
            list($sl, $card, $emp_id, $uname, $date, $time, $terminal, $inout, $door) = $carray;
            $data = array('emp_id' => $emp_id, 'stime' => $time, 'date' => $date);
            Iorecords::create($data);
        }
        // dd($fa);

        // }


    }
    public function attendance_file(Request $req)
    {
        if (Auth::user()->can('upload-attendancefile')) {
            $this->Missing_attendanceService->attendance_file($req);
            return redirect('upload-attendance');
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }


    public function training_attendance(Request $req)
    {
        if (Auth::user()->can('upload-attendancefile')) {
            $this->Missing_attendanceService->training_attendance($req);
            return redirect('upload-attendance');
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
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

        $check_d = $this->Missing_attendanceService->check_d($request);

        if (count($check_d) > 0) {
            echo '<script>alert("once added!");</script>';
        } elseif (count($check_d) == 0) {
            $upload = $this->Missing_attendanceService->store($request);
            return redirect('upload-attendance');
        }

        //    return redirect()->targetUrl('upload-attendance');
        return redirect()->back()->with('success', 'Attendance Request Sent Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        if (Auth::user()->can('dashboard-attendance-report')) {


            $staff = Auth::user()->employeeInfo->emp_id;
            $from = date('Y-m-01');
            $start = strtotime($from);
            $to = date('Y-m-d');
            $end = strtotime($to);
            $date = new DateTime('m');
            $report = $this->Missing_attendanceService->get_report($staff);
            $dept = $this->Missing_attendanceService->get_dept();
            $employee = $this->Missing_attendanceService->get_employee();
            $holiday = $this->Missing_attendanceService->get_holiday();

            $weekend = $this->Missing_attendanceService->weekend($staff);

            $roster_dept = $this->Missing_attendanceService->roster_dept();
            $default_weekend = $this->Missing_attendanceService->default_weekend();
            // $roster_slot= Roster_slot::all();
            // $edept=Auth::user()->employeeInfo->dept_code;
            $weeklyLeave = $this->Missing_attendanceService->weeklyLeave($staff);
            $edept = 'SY';
            $leave = $this->Missing_attendanceService->get_leave($staff);
            $rostering = $this->Missing_attendanceService->rostering($staff);
            $default_time = $this->Missing_attendanceService->default_time();
            $incident = $this->Missing_attendanceService->incident();
            $ramadan = $this->Missing_attendanceService->ramadan();
            $emp_roster_schedule = $this->Missing_attendanceService->emp_roster_schedule($staff);
            $roster_holiday = $this->Missing_attendanceService->roster_holiday($staff);
            return view('report', compact('roster_holiday', 'emp_roster_schedule', 'ramadan', 'incident', 'default_time', 'rostering', 'default_weekend', 'roster_dept', 'edept', 'dept', 'employee', 'report', 'start', 'end', 'holiday', 'weekend', 'staff', 'leave', 'from', 'to', 'weeklyLeave'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }


    public function search_report(Request $req)
    {
        if (Auth::user()->can('dashboard-attendance-report')) {
            $dept = $this->Missing_attendanceService->get_dept();
            $staff = $req->staff;
            $employee = $this->Missing_attendanceService->get_employee();
            $holiday = $this->Missing_attendanceService->get_holiday();
            $from = $req->from;
            $start = strtotime($from);
            $to = $req->to;
            $end = strtotime($to);
            $report = Iorecords::where('date', '<=', $to)->where('date', '>=', $from)->where('emp_id', $staff)->get();
            $weekend = $this->Missing_attendanceService->weekend($staff);
            $weeklyLeave = $this->Missing_attendanceService->weeklyLeave($staff);
            $edept = $req->dept;
            $roster_dept = Option::where('option_name', 'roster_dept')->get();
            $default_weekend = Option::where('option_name', 'default_weekend')->get();
            $leave = $this->Missing_attendanceService->get_leave($staff);
            $rostering = $this->Missing_attendanceService->rostering($staff);
            $default_time = $this->Missing_attendanceService->default_time();
            $incident = $this->Missing_attendanceService->incident();
            $ramadan = $this->Missing_attendanceService->ramadan();
            $emp_roster_schedule = $this->Missing_attendanceService->emp_roster_schedule($staff);
            $roster_holiday = $this->Missing_attendanceService->roster_holiday($staff);
            return view('report', compact('roster_holiday', 'emp_roster_schedule', 'ramadan', 'incident', 'default_time', 'rostering', 'default_weekend', 'roster_dept', 'edept', 'staff', 'report', 'employee', 'dept', 'start', 'end', 'holiday', 'weekend', 'leave', 'from', 'to', 'weeklyLeave'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
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
        $this->Missing_attendanceService->delete($id);
        return redirect()->back()->with('success', 'Request has been deleted successfully!');
    }
}
