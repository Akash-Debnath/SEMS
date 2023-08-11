<?php
namespace App\Services;

use App\Repositories\RosterSetRepository;
use Illuminate\Support\Facades\Validator;

class RosterSetService 
{

    /**
     * @var rosterSetRepository
    */
    protected $rosterSetRepository;


    /**
     * UserService constructor.
     * @param rosterSetRepository $rosterSetRepository
     */
    public function __construct(RosterSetRepository $rosterSetRepository)
    {
        $this->rosterSetRepository = $rosterSetRepository;
    }


    /**
     * Get all employees resources by directing to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method getAllEmployee
     * @param $request department_code, roster_status
     * @return response
    */
    public function getAllEmployee($request)
    {
        return $this->rosterSetRepository->getAllEmployee($request);
    }



    /**
     * Get all slots resources by directing to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method getAllSlot
     * @param $request department_code
     * @return response
    */
    public function getAllSlot($request)
    {
        return $this->rosterSetRepository->getAllSlot($request);
    }



    /**
     * Get roster department resources by directing to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method getRosterDepartment
     * @param $request department_code
     * @return response
    */
    public function getRosterDepartment($request)
    {
        return $this->rosterSetRepository->getRosterDepartment($request);
    }



    /**
     * Get all departments resources by directing to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method getAllDepartment
     * @param $request void
     * @return response
    */
    public function getAllDepartment()
    {
        return $this->rosterSetRepository->getAllDepartment();
    }




    /**
     * Validate employee , type and store all roster employees resources by directing to rosterSetRepository [Same Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterSameTime
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days.
     * @return response
    */
    public function setRosterSameTime($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_ids' => 'required', 
            'type' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        return $this->rosterSetRepository->setRosterSameTime($request);
    }




    /**
     * Validate employee and store all roster employees resources by directing to rosterSetRepository [Same Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterMoreWeekend
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days, reason_for_extra_weekend.
     * @return response
    */
    public function setRosterMoreWeekend($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_ids' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        return $this->rosterSetRepository->setRosterMoreWeekend($request);
    }




    /**
     * Validate employee, department_code, type and store all roster employees resources by directing to rosterSetRepository [Custom Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterCustomTime
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days.
     * @return response
    */
    public function setRosterCustomTime($request)
    {
        $validator = Validator::make($request->all(),[
            'emp_ids' => 'required', 
            'dept_code' => 'required',
            'type' => 'required',        
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        return $this->rosterSetRepository->setRosterCustomTime($request);
    }



    /**
     * Validate reason and employee and store all roster employees resources by directing to rosterSetRepository [Custom Time]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterCustomMoreWeekend
     * @param $request department_code, employee_id, start_time, end_time, weekend_dates, working_days, reason_for_extra_weekend.
     * @return response
    */
    public function setRosterCustomMoreWeekend($request)
    {
        $validator = Validator::make($request->all(),[
            'customReason' => 'required', 
            'emp_ids' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        return $this->rosterSetRepository->setRosterCustomMoreWeekend($request);
    }


    
    /**
     * Store data of slotted employee data by directing to rosterSetRepository [Slot]
     * 
     * @author Akash Chandra Debnath
     * @method setRosterSlotData
     * @param $request employee_id,weekend_employees_id,dates,slotNo
     * @return void
    */
    public function setRosterSlotData($request)
    {
        return $this->rosterSetRepository->setRosterSlotData($request);
    }


    /**
     * For store new slot data redirected to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method addNewRosterSlot
     * @param department_code, new_slot_number, slot_start_time, slot_end_time
     * @return void 
    */
    public function addNewRosterSlot($request)
    {
        $validator = Validator::make($request->all(),[
            'dept' => 'required',
            // 'slotNo' => 'required|unique:roster_slots,slot_no',
            'slotFrom' => 'required',
            'slotTo' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->rosterSetRepository->addNewRosterSlot($request);
    }


    /**
     * For edit and store edited slot data redirected to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method updateRosterSlot
     * @param  new_slot_number, slot_start_time, slot_end_time
     * @return void 
    */
    public function updateRosterSlot($request, $id)
    {
        $validator = Validator::make($request->all(),[
            // 'slotNo' => 'required|unique:roster_slots,slot_no',
            'slotFrom' => 'required',
            'slotTo' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->rosterSetRepository->updateRosterSlot($request, $id);
    }



    /**
     * For delete slot data redirected to rosterSetRepository
     * 
     * @author Akash Chandra Debnath
     * @method deleteRosterSlot
     * @param slot_id
     * @return void 
    */
    public function deleteRosterSlot($id)
    {
        return $this->rosterSetRepository->delete($id);
    }


}