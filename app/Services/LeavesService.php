<?php

namespace App\Services;

use App\Repositories\LeavesRepository;

class LeavesService
{
    public function __construct(LeavesRepository $leavesRepository)
    {
        $this->LeavesRepository = $leavesRepository;
    }

    public function showLeaves()
    {
        return $this->LeavesRepository->showLeaves();
    }
    public function Department()
    {

        return $this->LeavesRepository->Department();
    }
    // show employee leave-list

    public function get_dept_asc()
    {
        return $this->LeavesRepository->get_dept_asc();
    }

    public function get_emp($request)
    {
        // $department = $request->dept;
        return $this->LeavesRepository->get_emp($request);
    }

    public function get_auth_leave()
    {
        // $year = Date('Y');
        return $this->LeavesRepository->get_auth_leave();
    }

    public function get_option()
    {
        return $this->LeavesRepository->get_option();
    }

    public function gen_leaves()
    {
        return $this->LeavesRepository->gen_leaves();
    }

    // show employee leave-list

    // employeeLeave

    public function get_emp_leave($request)
    {
        // $year = $request->year;
        // $department = $request->dept;
        // $staff = $request->emp;

        return $this->LeavesRepository->get_emp_leave($request);
    }
    // employee leave

    // --------------finished leave-list

    // leave-at-a-glance

    public function show_leave_glance()
    {
        return $this->LeavesRepository->show_leave_glance();
    }


    // yearly-leave



    //  show employee
    public function showEmployee($request)
    {

        // $department = $request->dept;

        return $this->LeavesRepository->showEmployee($request);
    }
    // yearly-leave




    // leave today

    public function getJoined($nD)
    {
       
        return $this->LeavesRepository->getJoined($nD);
    }

    public function get_leave_date($request)
    {
        // $date = date("Y-m-d", strtotime($request->date));
        return $this->LeavesRepository->get_leave_date($request);
    }

    public function get_arc_emp()
    {
        return $this->LeavesRepository->get_arc_emp();
    }


    public function AuthcarryForwardLeave($request)
    {
        return $this->LeavesRepository->AuthcarryForwardLeave($request);
    }

    public function carryForwardLeave($request)
    {
        return $this->LeavesRepository->carryForwardLeave($request);
    }


    public function showMultipleEmpByDept($request)
    {
        return $this->LeavesRepository->showMultipleEmpByDept($request);
    }

    public function getTodayLeave($date)
    {
        return $this->LeavesRepository->getTodayLeave($date);
    }

    public function Employee()
    {

        return $this->LeavesRepository->Employee();
    }

    public function getEmployeebyArray($emps,$department){
        return $this->LeavesRepository->getEmployeebyArray($emps,$department);
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
