<?php

namespace App\Services;

use App\Repositories\LeaveRequestRepository;
use Illuminate\Support\Facades\Validator;

class LeaveRequestService
{
    protected $leaveRequestRepository;
    public function __construct(LeaveRequestRepository $leaveRequestRepository)
    {
        $this->LeaveRequestRepository = $leaveRequestRepository;
    }

    public function employee()
    {
        return $this->LeaveRequestRepository->employee();
    }

    public function option()
    {
        return $this->LeaveRequestRepository->option();
    }

    public function genLeave()
    {
        return $this->LeaveRequestRepository->genLeave();
    }

    public function create_req($req)
    {
        $validator = Validator::make($req->all(), [
            'leave_type' => 'required',
        ]);
        return $this->LeaveRequestRepository->create_req($req);
    }

    public function leaveAttachment($req)
    {
        return $this->LeaveRequestRepository->leaveAttachment($req);
    }

    public function carryForwardLeave($eid, $newYear)
    {
        return $this->LeaveRequestRepository->carryForwardLeave($eid, $newYear);
    }
}
