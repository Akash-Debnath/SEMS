<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class AttendanceApiService
{

    public function getZktecoAttendanceData($stdate, $enDate)
	{
		$conn = [
			['ip' => '192.168.10.240', 'password' => 3090],
			['ip' => '192.168.10.241', 'password' => 3090],
			['ip' => '192.168.10.242', 'password' => 3090],
			['ip' => '192.168.10.243', 'password' => 3090],
			['ip' => '192.168.10.244', 'password' => 3090],
			['ip' => '192.168.10.245', 'password' => 3090]
			//	['ip' => '118.179.144.62','password' => 3090]
		];

		$machineErrorIps = [];
		$allUserInfo = [];
		$allLogs = [];
		foreach ($conn as $ipval) {
			try {
				$allUserInfo = getMachineInstanceInfo($ipval['ip'], $ipval['password'])->get_all_user_info()->to_array();
				$allUserInfo = array_column($allUserInfo['Row'], NULL, 'PIN2');
				break;
			} catch (\Exception $e) {
			}
		}
		foreach ($conn as $val) {
			try {
				$m = getMachineInstanceInfo($val['ip'], $val['password']);
				$logs = $m->get_att_log()->filter_by_date(['start' => $stdate, 'end' => $enDate])->filter_by_verified(1)->to_array();
				if (!empty($logs['Row'])) {
					if (!isset($logs['Row'][0])) {
						$logs['Row'] = [$logs['Row']];
					}
					// add machine ip to array
					$logs['Row'] = array_map(function ($item) use ($val) {
						$ipSlice = explode(".", $val['ip']);
						$newVal['machineIp'] = end($ipSlice);
						return $item + $newVal;
					}, $logs['Row']);
					$allLogs = @array_merge(
						$allLogs,
						isset($logs['Row']) ? $logs['Row'] : []
					);
				}
			} catch (\Exception $e) {
				$machineErrorIps[] = $val['ip'];
			}
		}
		// if (!empty($machineErrorIps)) {
		// 	$this->sendIpErrorEmail($machineErrorIps);
		// }

		$data = [
			'allUserInfo' => $allUserInfo,
			'allLogs' => $allLogs,
		];

		return $data;
	}


	/**
	 * For getting all attendance data from machine by calling 'getZktecoAttendanceData()' method
	 * @method getMachineInstance
	 * @Warning : FilePath of localhost and livehost isn't same.
	*/
	public function getMachineInstance()
	{
		$stdate = date('Y-m-d');
		$enDate = date('Y-m-d');
		$allLogs = $this->getZktecoAttendanceData($stdate, $enDate);
		if ($allLogs['allLogs']) {
			$year = date('y');
			$month = date('m');
			$day = date('d');
            // dd($allLogs);
			$textFileName = $month . $day . $year . ".txt";
			$filePath = base_path()."\attendance_files/" . $textFileName;

			$file = fopen($filePath, "w") or die("Unable to open file!");
			$txt = '"No.","Card No","Employee ID","User name","Date","Time","Terminal","IN/OUT","Door"';
			fwrite($file, $txt . "\n");
			foreach ($allLogs['allLogs'] as $index => $log) {
				$dateTime = explode(" ", $log['DateTime']);
				$empId = sprintf('%04d', $log['PIN']);
				// $txt = '"' . ($index + 1) . '","' . $allLogs['allUserInfo'][$log['PIN']]['Card'] . '","' . $empId . '","' . $allLogs['allUserInfo'][$log['PIN']]['Name'] . '","' . $dateTime[0] . '","' . $dateTime[1] . '","----","01","' . $log['machineIp'] . '"';
				
				
				$txt = '"'.($index + 1).'","'."Card".'","'.$empId.'","'."Name".'","'.$dateTime[0].'","'.$dateTime[1].'","'."Terminal".'","'."In/Out".'","'."Door";
				fwrite($file, $txt . "\n");
			}
			fclose($file);
		}
	}

}