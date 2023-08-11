<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RamadanService;
use Illuminate\Support\Facades\Auth;

class RamadanController extends Controller
{

    /**
     * @var ramadanService
     */
    protected $ramadanService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(RamadanService $ramadanService)
    {
        $this->ramadanService = $ramadanService;
    }


    /**
     * Display a listing of all the resource of ramadans by directing to ramadanService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(Auth::user()->can('dashboard-ramadanTime-setRamadan')){
            $ramadanlist = $this->ramadanService->getAllRamadanList();
            return view('set-ramadan-time', compact('ramadanlist'));
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
     * Store a newly created ramdan resource in storage by directing to ramadanService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('ramadan-create')){
            $this->ramadanService->createRamadan($request);
            return redirect()->back()->with('success','Ramadan schduled Added Successfully!');
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
     * Show the modal for editing the specified ramadan resource by directing to ramadanService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if(Auth::user()->can('ramadan-edit')){
            return $this->ramadanService->editRamadan($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Update the specified ramdan resource in storage by .
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request
     * @param   $request start_date, end_date, start_time, end_time
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        if(Auth::user()->can('ramadan-edit')){
            $this->ramadanService->updateRamadan($request);
            return redirect()->back()->with('success','Ramadan Schedule Edited Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Remove the specified ramdan resource from storage by directing to ramadanService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id ramadan_time_id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('ramadan-delete')){
            $this->ramadanService->deleteRamadan($id);
            return redirect()->back()->with('fail','Ramadan Schedule Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }
}
