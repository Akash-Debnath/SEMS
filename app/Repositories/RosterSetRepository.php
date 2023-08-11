<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\EmployeeRosterSchedule;
use App\Models\RosterSlot;
use App\Models\RosteringControl;
use App\Models\WeekendTemp;
use App\Models\RosteringTemp;
use App\Models\Rostering;
use App\Models\RosterHoliday;
use App\Models\Weekend;
use Illuminate\Support\Facades\DB;
use App\Traits\QueryTrait;
use Illuminate\Support\Facades\Auth;


class RosterSetRepository implements RepositoryInterface
{

    /**
     * Get all employees by filtering department and roster_status from `employees` table
     * 
     * @author Akash Chandra Debnath
     * @method getAllEmployee
     * @param $request department_code and roster_status (Y/N)
    */
    public function getAllEmployee($request)
    {
        $dept  = $request->dept_code;
        $roster = $request->roster;
        return Employee::where('archive','=', "N")->where('dept_code',$dept )->where('roster', $roster)->orderByRaw('CONVERT(emp_id, Signed) ASC')->get();
    }



    /**
     * Get all slots by filtering department from `slots` table
     * 
     * @author Akash Chandra Debnath
     * @method getAllSlot
     * @param $request department_code
    */
    public function getAllSlot($request)
    {
        $dept  = $request->dept_code;
        return RosterSlot::where('dept_code',$dept )->get();
    }


    /**
     * Get roster department for showing slot for roster employees by filtering department from `departments` table.
     * 
     * @author Akash Chandra Debnath
     * @method getRosterDepartment
     * @param $request department_code
    */
    public function getRosterDepartment($request)
    {
        if(isset($request->dept_code)){
            $dept = $request->dept_code;
            $department=  Department::where('dept_code',$dept)->first();
            return $department->isSlot;
        }
    }

   
    /**
     * Get all department from `departments` table
     * 
     * @author Akash Chandra Debnath
     * @method getAllDepartment
     * @relation with `employees` table
     * @param void
    */
    public function getAllDepartment()
    {
        return Department::with('employee')->orderBy('dept_name', 'ASC')->get();
    }



    /**
     * Store roster/non-roster employees (same) department, employee_id, weekend, working days, stime, etime in `employee_roster_schedules` table.
     * 
     * @author Akash Chandra Debnath
     * @method setRosterSameTime
     * @param $request  department, employee_id, weekend_dates, working_dates, stime, etime
     * @return void
     * @todo check whether data inserts properly
    */
    public function setRosterSameTime($request)
    {
       
        $from = $request->sdate;
        $to = $request->edate;
        $employees = explode(',',$request->emp_ids);
        $weekends = $request->weekend;
        $startTime = $request->stime;
        $endTime = $request->etime;

        foreach($employees as $emp)
        {   
            for ( $i = $from; $i <= $to; $i = $i + 86400 )
            {   
                $thisDate = date( 'Y-m-d', $i );
                $day = date('l', $i);
                
                foreach($weekends as $wk)
                {
                    if(strtolower($day)==strtolower($wk)) {
                        $per[]=[
                            'emp_id' => $emp,
                            'ddate' => $thisDate,
                            'start_time' => '',
                            'end_time' => '',
                            'dept_code' => $request->dept_code,
                            'is_holiday' => "W",
                        ];
                    } else {
                        $per[]=[
                            'emp_id' => $emp,
                            'ddate' => $thisDate,
                            'start_time' => $thisDate." ".$startTime,
                            'end_time' => $thisDate." ".$endTime,
                            'dept_code' => $request->dept_code,
                            'is_holiday' => '',
                        ];
                    }
                }
            }
        }
        return EmployeeRosterSchedule::insert($per);
    }




    /**
     * Store employees data ( When weekends select more than max_weekend ) in `rostering_control`, `weekends`, `rosterings` table.
     * 
     * @author Akash Chandra Debnath
     * @method setRosterMoreWeekend
     * @param $request employee_ids, weekend_date, date_range, start_time and end_time
     * @return void
     * @todo use dbTransaction, check whether data insert properly and requirments meets or not.
    */
    public function setRosterMoreWeekend($request)
    {
        $employees = explode(',',$request->emp_ids);
        $weekends = $request->weekend;
        $startTime = $request->stime;
        $endTime = $request->etime;
        $from = $request->sdate;
        $to = $request->edate;
                 
        $rosterControl[]=[
            'emp_id' => $request->emp_ids,
            'dept_code' => $request->dept_code,
            'sdate' => date( 'Y-m-d', $request->sdate),
            'edate' => date( 'Y-m-d', $request->edate),
            'reason' => $request->reason,
            'sender_id' => Auth::user()->username,
            'admin_id' => 'NULL'
        ];

        RosteringControl::insert($rosterControl);


        foreach($employees as $emp)
        {   
            for ( $i = $from; $i <= $to; $i = $i + 86400 )
            {   
                $thisDate = date( 'Y-m-d', $i );
                $day = date('l', $i);
                
                foreach($weekends as $wk)
                {
                    if(strtolower($day)==strtolower($wk)) {
                        $weekendTemp[]=[
                            'emp_id' => $emp,
                            'date' => $thisDate
                        ];
                    } else {
                        $rosteringTemp[]=[
                            'emp_id' => $emp,
                            'stime' => $thisDate." ".$startTime,
                            'etime' => $thisDate." ".$endTime,
                            'is_incharge' => 'N'
                        ];
                    }
                }
            }
        }
        Weekend::insert($weekendTemp);
        Rostering::insert($rosteringTemp);
        return;
    }




    /**
     * Store roster/nonroster employees (custom)  department, employee_id, weekend, working days, stime, etime in `employee_roster_schedules` table.
     * 
     * @author Akash Chandra Debnath
     * @method setRosterCustomTime
     * @param $request  department, employee_id, weekend_dates, working_dates, stime, etime
     * @return void
     * @todo startTime and endTime is static it should change to dynamic request value
    */
    public function setRosterCustomTime($request)
    {

        $dates = $request->date;
        $employees = explode(',',$request->emp_ids);
        $leave = $request->leave_chk;
        $startTime = "09:00:00";
        $endTime = "18:00:00";

        foreach($employees as $emp)
        {
            foreach($dates as $key=>$thisDate)
            {
                if(in_array($thisDate,$leave))
                {
                    $per[]=[
                        'emp_id' => $emp,
                        'ddate' => $thisDate,
                        'start_time' => '',
                        'end_time' => '',
                        'dept_code' => $request->dept_code,
                        'is_holiday' => "W",
                    ];
                }else {
                    $per[]=[
                        'emp_id' => $emp,
                        'ddate' => $thisDate,
                        'start_time' => $thisDate." ".$startTime,
                        'end_time' => $thisDate." ".$endTime,
                        'dept_code' => $request->dept_code,
                        'is_holiday' => '',
                    ];
                }
            }
        }
        return EmployeeRosterSchedule::insert($per);
    }



    /**
     * Store employees data ( When weekends select more than max_weekend ) in `rostering_control`, `weekends`, `rosterings` table. [Custom]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterCustomMoreWeekend
     * @param $request employee_ids, weekend_date, date_range, start_time and end_time, custom_Reason
     * @return void
     * @todo use dbTransaction, check whether data insert properly and requirments meets or not.
    */
    public function setRosterCustomMoreWeekend($request)
    {
        $employees = explode(',',$request->emp_ids);
        $dates = $request->date;
        $leave = $request->leave_chk;
        $startTime = "09:00:00";
        $endTime = "18:00:00";
        $from = $request->sdate;
        $to = $request->edate;
                 
        $rosterControl[]=[
            'emp_id' => $request->emp_ids,
            'dept_code' => $request->dept_code,
            'sdate' => date( 'Y-m-d', $from),
            'edate' => date( 'Y-m-d', $to),
            'reason' => $request->customReason,
            'sender_id' => Auth::user()->username,
            'admin_id' => 'NULL'
        ];

        RosteringControl::insert($rosterControl);


        foreach($employees as $emp)
        {
            foreach($dates as $key=>$thisDate)
            {
                if(in_array($thisDate,$leave))
                {
                    $weekendArray[]=[
                        'emp_id' => $emp,
                        'date' => $thisDate
                    ];
                }else {
                    $rosteringArray[]=[
                        'emp_id' => $emp,
                        'stime' => $thisDate." ".$startTime,
                        'etime' => $thisDate." ".$endTime,
                        'is_incharge' => 'N'
                    ];
                }
            }
        }
        Weekend::insert($weekendArray);
        Rostering::insert($rosteringArray);
        return;
    }



    /**
     * For inserting roster slot employees data into `rosterings`, `holydays`, `weekends` table
     * 
     * @author Akash Chandra Debnath
     * @todo re-check and need to optimize
     * @param slot_number, department_code, employee_id, roster_date
     * @return void
    */
    public function setRosterSlotData($request)
    {
        $requestData = json_decode($request->allData, true);
        $slotData = $requestData['objSlot'];
        $weekendData = $requestData['objWeekend'];
        $holidayData = $requestData['objHoliday'];
        $dept = $requestData['dept'];

        $allSlotWithDept = RosterSlot::all();
        DB::beginTransaction();

        try
        {
            if(count($slotData) !== 0)
            {
                foreach($allSlotWithDept as $dbSlotData)
                {
                    if($dbSlotData->dept_code == $dept)
                    {
                        foreach($slotData as $date=>$value)
                        {
                            if(isset($value[$dbSlotData->slot_no])){
                                $from = $dbSlotData->from;
                                $to = $dbSlotData->to;
                                $slotEmployees = $value[$dbSlotData->slot_no];
                                foreach($slotEmployees as $emp)
                                {
                                    $rosterings[]=[
                                        'emp_id' => $emp,
                                        'stime' => $date." ".$from,
                                        'etime' => $date." ".$to,
                                        'is_incharge' => 'N'
                                    ];
                                }
                            }
                        }
                    }
                }
                Rostering::insert($rosterings);
            }
    
    
            if(count($holidayData) !== 0)
            {
                foreach($holidayData as $date=>$holidayEmployees)
                {
                    foreach($holidayEmployees as $emp)
                    {
                        $holidays[]=[
                            'emp_id' => $emp,
                            'date' => $date
                        ];
                    }
                }
                RosterHoliday::insert($holidays);
            }
    
    
            if(count($weekendData) !== 0)
            {
                foreach($weekendData as $date=>$weekendEmployees)
                {
                    foreach($weekendEmployees as $emp)
                    {
                        $weekend[] = [
                            'emp_id' => $emp,
                            'date' => $date
                        ];
                    }
                }
                Weekend::insert($weekend);
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
        }
        return;
    }


    /**
     * For store new slot data to `roster_slots` table , Model name - RosterSlot
     * 
     * @author Akash Chandra Debnath
     * @method addNewRosterSlot
     * @param department_code, new_slot_number, slot_start_time, slot_end_time
     * @return void 
    */
    public function addNewRosterSlot($request)
    {
        return RosterSlot::create(['dept_code' => $request->dept, 'slot_no' => $request->slotNo, 'from' => $request->slotFrom, 'to' => $request->slotTo]);
    }


    
    /**
     * For store modified slot data to `roster_slots` table , Model name - RosterSlot
     * 
     * @author Akash Chandra Debnath
     * @method updateRosterSlot
     * @param slot_number, slot_start_time, slot_end_time
     * @return void 
    */
    public function updateRosterSlot($request, $id)
    {
        return RosterSlot::where('id', $id)->update(['slot_no' => $request->slotNo, 'from' => $request->slotFrom, 'to' => $request->slotTo]);
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
        //
    }



    public function update(array $data, $id)
    {
        return true;
    }



    
    /**
     * Remove specified slot resources from `roster_slots` table.
     * 
     * @author Akash Chandra Debnath
     * @method delete
     * @param $id slot_id
     * @return response
    */
    public function delete($id)
    {
        return RosterSlot::findOrFail($id)->delete();
    }

}