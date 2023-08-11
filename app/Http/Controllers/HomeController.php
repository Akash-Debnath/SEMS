<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeController extends Controller
{

    /**
     * @var employeeService
     */
    protected $employeeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    // public function getZktecoAttendanceData($stdate,$enDate)
    // {
    //     $conn = [
	// 		['ip' => '192.168.10.240','password' => 3090],
	// 		['ip' => '192.168.10.241','password' => 3090],
	// 		['ip' => '192.168.10.242','password' => 3090],
	// 		['ip' => '192.168.10.243','password' => 3090],
	// 		['ip' => '192.168.10.244','password' => 3090],
	// 		['ip' => '192.168.10.245','password' => 3090]
    //     //	['ip' => '118.179.144.62','password' => 3090]
	// 	];
		
	// 	$machineErrorIps = [];
	// 	$allUserInfo = [];
	// 	$allLogs = [];
	// 	foreach($conn as $ipval){
	// 		try{ 
	// 			$allUserInfo =getMachineInstanceInfo($ipval['ip'],$ipval['password'])->get_all_user_info()->to_array();
	// 			$allUserInfo = array_column($allUserInfo['Row'], NULL, 'PIN2');
	// 			break;
	// 		}catch(\Exception $e) { 
				
	// 		}
			
	// 	}
	// 	foreach($conn as $val){
	// 		try{
	// 			$m = getMachineInstanceInfo($val['ip'],$val['password']);
	// 			$logs = $m->get_att_log()->filter_by_date(['start'=>$stdate,'end'=>$enDate])->filter_by_verified(1)->to_array();  
	// 			if(!empty($logs['Row'])){
	// 				if(!isset($logs['Row'][0])){
	// 					$logs['Row']= [$logs['Row']];
	// 				}
	// 				// add machine ip to array
	// 				$logs['Row'] = array_map(function($item) use ($val) {
	// 					$ipSlice = explode(".",$val['ip']);
	// 					$newVal['machineIp'] = end($ipSlice);
	// 					return $item+$newVal;
						
	// 				}, $logs['Row']);
	// 				$allLogs = @array_merge(
	// 					$allLogs, isset($logs['Row']) ? $logs['Row'] : []
	// 				);
	// 			}

	// 		}catch(\Exception $e){ 
	// 			$machineErrorIps[] = $val['ip'];
	// 		}
			
			
	// 	}
	// 	if(!empty($machineErrorIps)){
	// 		$this->sendIpErrorEmail($machineErrorIps);
	// 	}
		
	// 	$data = [
	// 		'allUserInfo' => $allUserInfo,
	// 		'allLogs' => $allLogs,
	// 	];
		
	// 	return $data;

    //     // $zkteco = getMachineInstanceInfo('192.168.10.245',3090)->get_all_user_info()->to_array();
    //     // print_r($zkteco);
    //     // exit;
    //     // return 1;
    // }
    // public function getMachineInstance()
    // {
    //     $stdate = date('Y-m-d'); 
	// 	$enDate = date('Y-m-d');
	// 	$allLogs = $this->getZktecoAttendanceData($stdate,$enDate);
        
	// 	if($allLogs['allLogs']){
	// 		$year = date('y');
	// 		$month = date('m');
	// 		$day = date('d');
		
	// 		$textFileName = $month.$day.$year.".txt";
	// 		$filePath = "../attendance_files/".$textFileName;

	// 		$file = fopen($filePath, "w") or die("Unable to open file!");
	// 		$txt = '"No.","Card No","Employee ID","User name","Date","Time","Terminal","IN/OUT","Door"';
	// 		fwrite($file, $txt."\n");
	// 		foreach($allLogs['allLogs'] as $index => $log){
	// 			$dateTime = explode(" ",$log['DateTime']);
	// 			$empId = sprintf('%04d', $log['PIN']);
	// 			$txt = '"'.($index+1).'","'.$allLogs['allUserInfo'][$log['PIN']]['Card'].'","'.$empId.'","'.$allLogs['allUserInfo'][$log['PIN']]['Name'].'","'.$dateTime[0].'","'.$dateTime[1].'","----","01","'.$log['machineIp'].'"';
	// 			fwrite($file, $txt."\n");
	// 		}
	// 		fclose($file);
	// 	}
	// }	

    /**
     * Display a all details information of the authenticated employee.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->username;
        $empInfo = Employee::where('emp_id',Auth::user()->username)->first();
        $facility = $this->employeeService->getAllFacility();
        $faci = $this->employeeService->getFacility($id);
        $stat = $this->employeeService->getStatus($id);
        $employeeGrade= $this->employeeService->getEmployeeGrade();
        return view('employee-details',compact('empInfo', 'facility', 'faci', 'stat', 'employeeGrade'));
    }



    /**
     * To shift username, email and password value from `employees` table to `users` table.
     * 
     * @author Akash Chandra Debnath
     * @method shift
     * @param void
     * @todo Establish better method for data shifting
     */
    // public function shift(){
    //     $employees = employee::get();
    //     // dd($employees);
    //     // exit();

    //     foreach($employees as $key => $value){
    //         User::create([
    //             'username'=>$value->emp_id,
    //             'email'=>$value->email,
    //             'password'=>$value->pass
    //         ]);
    //     }
    //     return "Data sent successfully";
    // }



    /**
     * To show password reset form
     * 
     * @author Akash Chandra Debnath
     * @method changePasswordViewFile
     * @param void
    */
    public function changePasswordViewFile()
    {
        return view('changePass');
    }


    /**
     * To change password by putting old password
     * 
     * @author Akash Chandra Debnath
     * @method changePassword
     * @param $request old_password, new_password, confirm_new_password
    */
    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->current_password, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("fail","Your current password does not matches with the password!");
        }

        if(strcmp($request->current_password, $request->new_password) == 0){
            // Current password and new password same
            return redirect()->back()->with("fail","New Password cannot be same as your current password.");
        }

        if(strcmp($request->new_password_confirmation, $request->new_password) != 0){
            // Current password and new password same
            return redirect()->back()->with("fail","New Password & Re-type is not same");
        }


        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
        ]);


        $id = Auth::user()->username;
        User::where('username', $id)->update(['password' => Hash::make($request->new_password)]);
        Employee::where('emp_id', $id)->update(['pass' => Hash::make($request->new_password)]);
        return redirect()->back()->with("success","Password Changed Successfully!");

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
        $this->employeeService->createEmployee($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      
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
