<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RosterPendingService;
use Illuminate\Support\Facades\Auth;

class RosterPendingController extends Controller
{

    /**
     * @var rosterPendingService
     */
    protected $rosterPendingService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RosterPendingService $rosterPendingService)
    {
        $this->rosterPendingService = $rosterPendingService;
    }


    /**
     * Display list of all roster request pending resource by directing to rosterPendingService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-attendance-rosterPending')){
            $pendings = $this->rosterPendingService->getAllPendingRoster();
            $total = $this->rosterPendingService->totalPendingRequest();
            $employees = $this->rosterPendingService->getAllEmployee();
            $departments = $this->rosterPendingService->getAllDepartment();
            return view('roster-pending', compact('pendings', 'total', 'employees', 'departments'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
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
     * Update the specified roster pending request resource in storage by directing to rosterPendingService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request admin_id
     * @param  int  $id pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('rosterSettings-approve')){
            $this->rosterPendingService->approveHolidayRequest($request, $id);
            return redirect()->back()->with('success','Request Approved successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove the specified roster pending request resource in storage by directing to rosterPendingService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id roster_pending_request_id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('rosterSettings-refuse')){
            $this->rosterPendingService->refuseHolidayRequest($id);
            return redirect()->back()->with('fail','Request Refused Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
