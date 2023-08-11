<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FacilityService;
use Illuminate\Support\Facades\Auth;

class FacilityController extends Controller
{

    /**
     * @var facilityService
    */
    protected $facilityService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }


    /**
     * Display listing of all facility resource by directing to facilityService.
     * 
     * @author Akash chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-settings-facility')){
            $facilities = $this->facilityService->getAllFacility();
            return view('facility', compact('facilities'));
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
     * Store a newly created facility resource in storage by directing to facilityService.
     *
     * @author Akash chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('facility-create')){
            $this->facilityService->createFacility($request);
            return redirect()->back()->with('success','Facility Added Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
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
     * Show modal for editing the specified facility resource by directing to facilityService.
     *
     * @author Akash chandra Debnath
     * @method edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('facility-edit')){
            return $this->facilityService->editFacility($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified facility resource in storage by directing to facilityService.
     *
     * @author Akash chandra Debnath
     * @method upadte
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->can('facility-edit')){
        $this->facilityService->updateFacility($request);
        return redirect()->back()->with('success','Facility Updated Successfully!');
    } else {
        return redirect()->back()->with('fail', 'You are not able to go through!');
    }
    }

    /**
     * Remove the specified facility resource from storage by directing to facilityService.
     *
     * @author Akash chandra Debnath
     * @method destroy
     * @param  int  $id facility_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('facility-delete')){
            $this->facilityService->deleteFacility($id);
            return redirect()->back()->with('fail','Facility Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
