<?php
namespace App\Services;

use App\Repositories\RosterPendingRepository;
use Illuminate\Support\Facades\Validator;

class RosterPendingService 
{

    /**
     * @var rosterPendingRepository
    */
    protected $rosterPendingRepository;


    /**
     * UserService constructor.
     * @param rosterPendingRepository $rosterPendingRepository
    */
    public function __construct(RosterPendingRepository $rosterPendingRepository)
    {
        $this->rosterPendingRepository = $rosterPendingRepository;
    }


    /**
     * Display list of all roster request pending resource by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllPendingRoster
     * @return \Illuminate\Http\Response
    */
    public function getAllPendingRoster()
    {
        return $this->rosterPendingRepository->all(); 
    }


    /**
     * Display list of all departments by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllDepartment
     * @return \Illuminate\Http\Response
    */
    public function getAllDepartment()
    {
        return $this->rosterPendingRepository->getAllDepartment(); 
    }


    /**
     * Display total roster request pending resource by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method totalPendingRequest
     * @return \Illuminate\Http\Response
    */
    public function totalPendingRequest()
    {
        return $this->rosterPendingRepository->totalPendingRequest(); 
    }


    /**
     * Get all employees details by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllEmployee
     * @return \Illuminate\Http\Response
    */
    public function getAllEmployee()
    {
        return $this->rosterPendingRepository->allEmployee();
    }


    /**
     * Update the specified roster pending request resource in storage by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method approveHolidayRequest
     * @param  \Illuminate\Http\Request  $request admin_id
     * @param  int  $id pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function approveHolidayRequest($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'admin_id' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->rosterPendingRepository->approveHolidayRequest($request, $id);
    }


    /**
     * Remove the specified roster pending request resource in storage by directing to rosterPendingRepository.
     *
     * @author Akash Chandra Debnath
     * @method refuseHolidayRequest
     * @param  int  $id roster_pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function refuseHolidayRequest($id)
    {
        return $this->rosterPendingRepository->refuseHolidayRequest($id);
    }

}