<?php

namespace App\Services;

use App\Repositories\PendingLeaveRepository;
use Illuminate\Support\Facades\Validator;

class PendingLeaveService
{
    protected $pendingLeaveService;

    public function __construct(PendingLeaveRepository $pendingLeaveService)
    {
        $this->PendingLeaveRepository = $pendingLeaveService;
    }

    public function employee()
    {
        return  $this->PendingLeaveRepository->employee();
    }

    public function employeeById($id)
    {
        return $this->PendingLeaveRepository->employeeById($id);
    }

    public function dept()
    {
        return $this->PendingLeaveRepository->dept();
    }

    public function approval()
    {
        return  $this->PendingLeaveRepository->approval();
    }

    public function verify()
    {
        return  $this->PendingLeaveRepository->verify();
    }

    public function cancel()
    {
        return  $this->PendingLeaveRepository->cancel();
    }

    public function option()
    {
        return  $this->PendingLeaveRepository->option();
    }

    public function genuity_leaves()
    {
        return $this->PendingLeaveRepository->genuity_leaves();
    }

    public function leave_attachment($id)
    {
        return $this->PendingLeaveRepository->leave_attachment($id);
    }

    public function leave($id)
    {
        return $this->PendingLeaveRepository->leave($id);
    }

    public function leaveByAV($staff, $year)
    {
        return $this->PendingLeaveRepository->leaveByAV($staff, $year);
    }

    public function update($data, $id)
    {
        return $this->PendingLeaveRepository->update($data, $id);
    }

    public function Leave_Verify($req, $id)
    {
        return $this->PendingLeaveRepository->Leave_Verify($req, $id);
    }

    public function cancel_req($req, $id)
    {
        return $this->PendingLeaveRepository->cancel_req($req, $id);
    }

    public function cancel_approve($req, $id)
    {
        // $cancel_approve_date = Date('Y-m-d');

        // $data = array('cancel_approve_date' => $cancel_approve_date);


        return $this->PendingLeaveRepository->cancel_approve($req, $id);
    }

    public function Status($eid, $year)
    {
        return $this->PendingLeaveRepository->Status($eid, $year);
    }

    public function deleteLeave($id)
    {
        return $this->PendingLeaveRepository->deleteLeave($id);
    }

    public function update_req($req, $id)
    {
        return   $this->PendingLeaveRepository->update_req($req, $id);
    }
    
    public function updateLeaveRequest($req,$id){
        return   $this->PendingLeaveRepository->updateLeaveRequest($req,$id);
    }

    public function carryForwardLeave($id, $newYear)
    {
        return $this->PendingLeaveRepository->carryForwardLeave($id, $newYear);
    }

    public function LeaveApprovalViaComment($req, $id)
    {
        return $this->PendingLeaveRepository->LeaveApprovalViaComment($req, $id);
    }
}
