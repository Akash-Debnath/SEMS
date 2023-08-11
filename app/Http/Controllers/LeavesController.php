<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LeavesService;
use Illuminate\Support\Facades\Route;

class LeavesController extends Controller
{
    protected $leavesService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // leave-list
    // public function leaves(){
    //     return view('leave-list');
    //   }
    public function __construct(LeavesService $leavesService)
    {
        $this->LeavesService = $leavesService;
    }


    public function showEmployee_leaveList()
    {
        if (Auth::user()->can('dashboard-leaveList')) {

            $year = Date('Y');
            $dept =  $this->LeavesService->get_dept_asc();
            $department = Auth::user()->employeeInfo->department->dept_code;
            $staff = Auth::user()->username;
            // $employee =  $this->LeavesService->get_emp($request);
            $leave = $this->LeavesService->get_auth_leave();
            $carry = $this->LeavesService->AuthcarryForwardLeave($year);
            $option = $this->LeavesService->get_option();
            $genuity_leaves = $this->LeavesService->gen_leaves();
            return view('leave-list', compact('department', 'dept', 'leave', 'option', 'genuity_leaves', 'year', 'carry', 'staff'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }


    //    employee
    public function employeeLeave(Request $request)
    {
        if (Auth::user()->can('dashboard-leaveList')) {
            $year = $request->year;
            $department = $request->dept;
            $staff = $request->emp;
            $option = $this->LeavesService->get_option();
            $genuity_leaves = $this->LeavesService->gen_leaves();
            // $employee = $this->LeavesService->get_emp($request);
            $leave = $this->LeavesService->get_emp_leave($request);
            $carry = $this->LeavesService->carryForwardLeave($request);
            $dept = $this->LeavesService->showLeaves();


            return view('leave-list', compact('leave', 'dept', 'option', 'genuity_leaves', 'staff', 'year', 'carry', 'department'));
        } else {
            return redirect()->back()->with('fail', 'you are not able to go through');
        }
    }

    // yearly-leave



    public function showYearlyLeave()
    {
        if (Auth::user()->can('dashboard-leave-yearlyLeaveReport')) {
            $dept = $this->LeavesService->get_dept_asc();
            $option = $this->LeavesService->get_option();
            $employees = $this->LeavesService->get_arc_emp();
            return view('yearly-leave-report', compact('dept', 'option', 'employees'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }



    /**
     * Get Employee List Depend On Multiple Department . Function get Department List[] and return Active employes.
     * Dpt = Department and Emp = Employee
     * @param array 
     * @author Tahrim
     * @todo Code must be refeactoring 
     * @return void
     */

    public function showMultipleEmpByDept(Request $request)
    {
        if (Auth::user()->can('dashboard-leave-yearlyLeaveReport')) {
            // $dptList = $request->dptList;
            // $employee = [];
            // if (is_array($dptList)) {
            //     $employee = Employee::whereIn('dept_code', $dptList)->where('archive', 'N')->get();
            // }
            $employee = $this->LeavesService->showMultipleEmpByDept($request);
            return response()->json([
                'status' => 200,
                'employeeData' => $employee
            ]);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }

    public function searchYearlyLeave(Request $req)
    {
        if (Auth::user()->can('dashboard-leave-yearlyLeaveReport')) {
            $dept = $this->LeavesService->Department();
            $department = $req->dept;
            $emps = $req->emp;
            $option = $this->LeavesService->get_option();
            $employees = $this->LeavesService->getEmployeebyArray($emps, $department);


            return view('yearly-leave-report', compact('dept', 'employees', 'option'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }







    // leave today

    public function todayLeaveIndex()
    {
        if(Auth::user()->can('dashboard-leave-todayLeave')){
        
        $date = date('Y-m-d');
        $nD = date('Y-m-d', strtotime($date . "- 1 days"));
        $leave = $this->LeavesService->getTodayLeave($date);
        $employee = $this->LeavesService->Employee();
        $joined = $this->LeavesService->getJoined($nD);
        return view('leave-today', compact('leave', 'employee', 'date', 'joined'));
            
    }else {
        return redirect()->back()->with('fail', 'You are not able to go through');
    }
    }

    public function searchLeave(Request $request)
    {
        if(Auth::user()->can('dashboard-leave-todayLeave')){
        $date = date("Y-m-d", strtotime($request->date));
        $nD = date('Y-m-d', strtotime($request->date . "- 1 days"));
        $leave = $this->LeavesService->getTodayLeave($date);
        $employee = $this->LeavesService->Employee();
        $joined = $this->LeavesService->getJoined($nD);
        return view('leave-today', compact('leave', 'employee', 'date', 'joined'));
        }else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
