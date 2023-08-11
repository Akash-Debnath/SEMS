<?php

namespace App\Repositories;

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
use App\Models\RamadanOfficeTime;
use App\Models\EmployeeRosterSchedule;
use App\Models\RosterHoliday;
use App\Models\WeeklyLeave;
use Illuminate\Support\Facades\Auth;
use DateTime;

class Missing_attendanceRepository implements RepositoryInterface
{

    // missing-attendance-requests

    public function get_employee()
    {
        return Employee::where('archive', 'N')->get();
    }

    public function approve()
    {
        return Missing_attendance::where('m_approved_date', NULL)->where('a_verified_date', NULL)->get();
    }

    public function verify()
    {
        return Missing_attendance::where('m_approved_date', '!=', NULL)->where('a_verified_date', NULL)->get();
    }

    // public function index()
    // {
    //     // $employee = Employee::where('archive', 'N')->get();
    //     // $approve = Missing_attendance::where('m_approved_date', NULL)->where('a_verified_date', NULL)->get();
    //     // $verify = Missing_attendance::where('m_approved_date', '!=',NULL)->where('a_verified_date', NULL)->get();
    //     return view('missing-attendance-req', compact('approve', 'verify', 'employee'));
    // }


    // approve attendance req


    public function get_Missing_id($id)
    {
        return Missing_attendance::where('id', $id)->get();
    }

    public function update_Missing_id($id)
    {

        $date = date('Y-m-d');
        $manager_id = Auth::user()->employeeInfo->emp_id;
        $data = array('m_approved_date' => $date, 'manager_id' => $manager_id);
        return Missing_attendance::where('id', $id)->update($data);
    }
    // public function approve_att_req($id)
    // {
    //     // $get = Missing_attendance::where('id', $id)->get();
    //     foreach ($get as $g) {
    //         // $in = $g->in;
    //         // $date = date('Y-m-d');
    //         // $manager_id = Auth::user()->employeeInfo->emp_id;
    //         // $data = array('m_approved_date'=> $date,'manager_id'=>$manager_id);
    //         // $update = Missing_attendance::where('id',$id)->update($data);


    //     }

    //     return redirect('missing-attendance-req');
    // }




    // verify attendance req

    public function update_verified_missing_att($id)
    {
        $date = date('Y-m-d');
        $admin_id = Auth::user()->employeeInfo->emp_id;
        $data = array('a_verified_date' => $date, 'admin_id' => $admin_id);
        return Missing_attendance::where('id', $id)->update($data);
    }

    public function add_att($add_att)
    {
        return Iorecords_temp::create($add_att);
    }

    // public function verify_att_req($id)
    // {
    //     // $get = Missing_attendance::where('id', $id)->get();
    //     foreach ($get as $g) {
    //         // $in = $g->in;
    //         // $date = date('Y-m-d');
    //         // $admin_id = Auth::user()->employeeInfo->emp_id;
    //         // $data = array('a_verified_date'=> $date,'admin_id'=>$admin_id);
    //         $add_att = array('emp_id'=>$g->emp_id,'stime'=>$g->in,'etime'=>$g->out, 'date'=>$g->date);
    //         // $update = Missing_attendance::where('id',$id)->update($data);
    //         $iorecord = new Iorecords_temp;
    //         $insert = Iorecords_temp::create($add_att);

    //     }

    //     return redirect('missing-attendance-req');
    // }


    // upload---------------------------------------------
    public function get_dept()
    {
        return Department::all();
    }
    // public function upload_Attendance()
    // {
    //     // $dept = Department::all();
    //     // $employee = Employee::where('archive', 'N')->get();
    //     return view('upload-attendance-info', compact('dept', 'employee'));
    // }



    // upload attendance-file

    public function attendance_file($req)
    {
        if ($req->hasfile('file')) {
            $file = $req->file('file');
            $extenstion = $file->getClientOriginalExtension();
            if (strtoupper($extenstion) == "TXT") {
                $filename = time() . '.' . $extenstion;
                $file->move('../attendance_files/', $filename);
                $req->file = $filename;

                $url = "../attendance_files/" . $filename;
                $string = file_get_contents($url);
                $a = ['"', '\n'];
                $b = ['', ''];
                $strreplace = str_replace($a, $b, $string);
                file_put_contents($url, $strreplace);

                $file = fopen("../attendance_files/" . $filename, "r");

                while (!feof($file)) {
                    $content = fgets($file);
                    $carray = explode(",", $content);
                    if (count($carray) < 9) continue;
                    list($sl, $card, $emp_id, $uname, $date, $time, $terminal, $inout, $door) = $carray;
                    $data = array('emp_id' => $emp_id, 'stime' => $time, 'date' => $date);
                    $attendance = new Iorecords;
                    Iorecords::create($data);
                }
                return redirect()->back()->with('success', 'Attendance Uploaded Successfully!');
            } else {
                return redirect()->back()->with('fail', "Wrong file format! Only .txt file is acceptable.");
            }
        } else {
            return redirect()->back()->with('fail', "You're submitted without any file!");
        }
    }


    // upload training attendance file

    public function training_attendance($req)
    {
        if ($req->hasfile('training_file')) {
            $file = $req->file('training_file');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            if (strtoupper($extenstion) == "TXT") {
                $file->move('../training_attendance_files/', $filename);
                $req->training_file = $filename;

                $url = "../training_attendance_files/" . $filename;
                $string = file_get_contents($url);
                $a = ['"', '\n'];
                $b = ['', ''];
               
                $strreplace = str_replace($a, $b, $string);
                file_put_contents($url, $strreplace);

                $file = fopen("../training_attendance_files/" . $filename, "r");
                // dd($file);
                while (!feof($file)) {
                    $content = fgets($file);
                    // $carray = explode(",", $content);
                     $carray = explode("\t", $content);
                    // dd($carray);
                    if (count($carray) < 9) continue;
                    // list($sl, $card, $emp_id, $uname, $date, $time, $terminal, $inout, $door) = $carray;
                    list($dateTime, $emp_id,$fname,$lname,$card,$device,$event,$verfyType,$inout )=$carray;
                    
                    
                    if($verfyType=='Only Fingerprint'){
                        $data = array('emp_id' => $emp_id, 'stime' => date('H:i:s a',strtotime($dateTime)), 'date' => date('Y-m-d',strtotime($dateTime)));
                        // $attendance = new Iorecords_temp;
                        $insert = Iorecords::create($data);
                    }
                        
                    
                    
                   
                }
                return redirect()->back()->with('success', 'Attendance Uploaded Successfully!');
            } else {
                return redirect()->back()->with('fail', "Wrong file format! Only .txt file is acceptable.");
            }
        } else {
            return redirect()->back()->with('fail', "You're submitted without any file!");
        }
    }

    // attendance store


    public function store($request)
    {
        $reason = $request->reason;
        $dept = $request->dept;
        $staff = $request->staff;
        $date = $request->date;
        $in = $request->in;
        $out = $request->out;
        $data = array('emp_id' => $request->staff, 'date' => $request->date, 'in' => $request->in, 'out' => $request->out, 'reason' => $request->reason, 'status' => 'p');
        return Missing_attendance::create($data);
    }

    public function check_d($request)
    {
        $staff = $request->staff;
        $date = $request->date;
        return Missing_attendance::where('emp_id', $staff)->where('date', $date)->get();;
    }


    public function get_report($staff)
    {
        return Iorecords::where('emp_id', $staff)->get();
    }

    public function get_holiday()
    {
        return Holyday::all();
    }

    public function roster_dept()
    {
        return Option::where('option_name', 'roster_dept')->get();
    }

    public function weekend($staff)
    {
        return Weekend::where('emp_id', $staff)->get();
    }

    public function default_weekend()
    {
        return Option::where('option_name', 'default_weekend')->get();
    }

    public function get_leave($staff)
    {

        return Leave::where('emp_id', $staff)->where('admin_approve_date', '!=', NULL)->where('m_approved_date', '!=', NULL)->get();
    }

    public function rostering($staff)
    {
        return Rostering::where('emp_id', $staff)->get();
    }

    public function default_time()
    {
        return Option::where('option_name', 'default_time')->get();
    }

    public function incident()
    {
        return Incident::all();
    }

    public function ramadan()
    {
        return RamadanOfficeTime::all();
    }

    public function emp_roster_schedule($staff)
    {
        return EmployeeRosterSchedule::where('emp_id', $staff)->get();
    }

    public function roster_holiday($staff)
    {
        return RosterHoliday::where('emp_id', $staff)->get();
    }
    
    public function weeklyLeave($staff){
        return WeeklyLeave::where('emp_id',$staff)->first();
    }
    public function all()
    {
        return true;
    }


    public function get($id)
    {
        return true;
    }



    public function create(array $data)
    {
        return true;
    }



    public function update(array $data, $id)
    {
        return true;
    }



    public function delete($id)
    {
        return Missing_attendance::where('id', $id)->delete();
    }
}
