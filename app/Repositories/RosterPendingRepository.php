<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\RosteringControl;

class RosterPendingRepository implements RepositoryInterface
{

    /**
     * Display list of all roster request pending resource from `rostering_controls` table.
     *
     * @author Akash Chandra Debnath
     * @method all
     * @return \Illuminate\Http\Response
    */
    public function all()
    {
        return RosteringControl::where('admin_id', 'NULL')->get();
    }


    /**
     * Display total roster request pending resource from `rostering_controls` table.
     *
     * @author Akash Chandra Debnath
     * @method totalPendingRequest
     * @return \Illuminate\Http\Response
    */
    public function totalPendingRequest()
    {
        return RosteringControl::where('admin_id', 'NULL')->count();
    }



    /**
     * Get all employees details from `employees` table.
     *
     * @author Akash Chandra Debnath
     * @method allEmployee
     * @return \Illuminate\Http\Response
    */
    public function allEmployee()
    {
        return Employee::where('archive', '=', "N")->orderByRaw('CONVERT(emp_id, Signed) ASC')->get();
    }



    /**
     * Display list of all departments from `departments` table.
     *
     * @author Akash Chandra Debnath
     * @method getAllDepartment
     * @return \Illuminate\Http\Response
    */
    public function getAllDepartment()
    {
        return Department::all();
    }



    /**
     * Update the specified roster pending request resource in `rostering_controls` table.
     *
     * @author Akash Chandra Debnath
     * @method approveHolidayRequest
     * @param  \Illuminate\Http\Request  $request admin_id
     * @param  int  $id pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function approveHolidayRequest($request, $id)
    {
        return RosteringControl::where('id', $id)->update(['admin_id'=> $request->admin_id]);
    }


    
    /**
     * Remove the specified roster pending request resource in `rostering_controls` table.
     *
     * @author Akash Chandra Debnath
     * @method refuseHolidayRequest
     * @param  int  $id roster_pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function refuseHolidayRequest($id)
    {
        return RosteringControl::where('id', $id)->delete();
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
        return true;
    }

}