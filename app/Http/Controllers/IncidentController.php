<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IncidentService;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{

    /**
     * @var incidentService
    */
    protected $incidentService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(IncidentService $incidentService)
    {
        $this->incidentService = $incidentService;
    }
    

    /**
     * Display all incidents by directing to incidentService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return all_incidents to view `incident.blade.php`
    */
    public function index()
    {
        // $incident= $this->incidentService->getAllIncident();
        // return view('incident', compact('incident'));
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
     * store incidents data by directing to incidentService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param $request incident_start_date, incident_end_date, incident_description
     * @return all_incidents to view `incident.blade.php`
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('incident-create')){
            $this->incidentService->createIncident($request);
            return redirect()->back()->with('success','Incident Added Successfully!');
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
     * Show the form for editing by directing to incidentService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param int $id incident_id
     * @return void
    */
    public function edit($id)
    {
        if(Auth::user()->can('incident-edit')){
            return $this->incidentService->editIncident($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Update incidents data by directing to incidentService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param $request incident_start_date, incident_end_date, incident_description
     * @return all_incidents to view `incident.blade.php`
    */
    public function update(Request $request)
    {
        if(Auth::user()->can('incident-edit')){
            $this->incidentService->updateIncident($request);
            return redirect()->back()->with('success','Incident Edited successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove incident with incident_id by redirecting incidentService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param $id incident_id
     * @return void
    */
    public function destroy($id)
    {
        if(Auth::user()->can('incident-delete')){
            $this->incidentService->deleteIncident($id);
            return redirect()->back()->with('fail','Incident Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Search incidents data with specific year by directing to incidentService.
     *
     * @author Akash Chandra Debnath
     * @method searchIncident
     * @param $request selected_year
     * @return all_incidents to view `incident.blade.php`
    */
    public function searchIncident(Request $request )
    {
        if(!$request->date_year) {
            $request->date_year = date('Y'); 
        }
        $selectedYear = $request->date_year;
        $incident = $this->incidentService->searchIncident($request);
        return view('incident', compact('incident', 'selectedYear'));
    }
}
