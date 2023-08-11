<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class LeavesRepository implements RepositoryInterface
{
    public function showLeaves()
    {

        return Department::all();
    }

    public function Department()
    {

        return Department::all();
    }

    public function Employee()
    {

        return Employee::where('archive', 'N')->get();
    }

    // show employee leave-list

    public function get_dept_asc()
    {
        return Department::orderBy('dept_name', 'ASC')->get();
    }

    public function get_emp($request)
    {
        $department = $request->dept;
        return Employee::where('dept_code', $department)->where('archive', 'N')->get();
    }

    

    public function get_auth_leave()
    {
        $year = Date('Y');
        return Leave::where('emp_id', Auth::user()->employeeInfo->emp_id)->whereYear('leave_start', $year)->get();
    }

    public function get_option()
    {
        return Option::where('option_name', 'leave_type')->get();
    }

    public function gen_leaves()
    {
        return Option::where('option_name', 'genuity_leaves_array')->get();
    }

    // show employee leave-list

    // employeeLeave

    public function get_emp_leave($request)
    {
        $year = $request->year;
        // $department = $request->dept;
        $staff = $request->emp;
        if($staff == null){
          $staff =  Auth::user()->employeeInfo->emp_id;
        }
        return Leave::where('emp_id', $staff)->whereYear('leave_start', $year)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->get();
    }

    public function AuthcarryForwardLeave( $year)
    {
        // $year = date('Y');
        $staff = Auth::user()->employeeInfo->emp_id;
        $date = strtotime($year . ' -1 year');
        $newYear = date('Y', $date);

        return Leave::where('emp_id', $staff)->whereYear('leave_start', $newYear)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->where('leave_type', 'AL')->get();
    }

    public function carryForwardLeave($request)
    {
        $year = $request->year;
        $staff = $request->emp;
        $date = strtotime($year . ' -1 year');
        $newYear = date('Y', $date);

        return Leave::where('emp_id', $staff)->whereYear('leave_start', $newYear)->where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->where('leave_type', 'AL')->get();
    }


    public function show_leave_glance()
    {
        return Leave::where('m_approved_date', '!=', NULL)->where('admin_approve_date', '!=', NULL)->get();
    }


    // yearly-leave



    //  show employee
    public function showEmployee($request)
    {

        $department = $request->dept;

        return Employee::whereIn('dept_code', $department)->where('archive', 'N')->get();
    }
    // yearly-leave




    // leave today

    public function getJoined($nD)
    {
       
        return Leave::whereDate('leave_end', $nD)->get();
    }

    public function get_leave_date($request)
    {

        $date = date("Y-m-d", strtotime($request->date));
        return Leave::whereDate('leave_start', '<=', $date)->whereDate('leave_end', '>=', $date)->get();
    }

    public function get_arc_emp()
    {
        return Employee::where('archive', 'N')->get();
    }
    public function showMultipleEmpByDept($request)
    {
        $dptList = $request->dptList;
        $employee = [];
        if (is_array($dptList)) {
            return  Employee::whereIn('dept_code', $dptList)->where('archive', 'N')->get();
        }
        // return;
    }

    public function getTodayLeave($date)
    {
        return Leave::whereDate('leave_start', '<=', $date)->whereDate('leave_end', '>=', $date)->where('admin_approve_date', '!=', null)->where('m_approved_date', '!=', null)->get();
    }

    public function getEmployeebyArray($emps,$department){
        if (!is_null($department) && is_null($emps)) {
           return Employee::whereIn('dept_code', $department)->where('archive', 'N')->get();
        } else {
            return Employee::whereIn('emp_id', $emps)->where('archive', 'N')->get();
        }
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
        return true;
    }
}
