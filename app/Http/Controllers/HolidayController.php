<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HolidayService;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * @var holidayService
     */
    protected $holidayService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }


    /**
     * Display a listing of all holidays by directing to holidayService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @param void
     * @return void
    */
    public function index()
    {
        //
    }



    /**
     * Display a listing of all holidays for a specific year by directing to holidayService.
     *
     * @author Akash Chandra Debnath
     * @method searchHoliday
     * @param $request selected_year
     * @return void
    */
    public function searchHoliday(Request $request)
    {
        if(!$request->date_year) {
            $request->date_year = date('Y'); 
        }
        $selectedYear = $request->date_year;
        $holiday= $this->holidayService->searchHoliday($request);
        
        return view('holiday', compact('holiday', 'selectedYear'));
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
     * Store a newly created holiday resource in storage by directing to holidayService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request holiday_date, reason/description
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('holiday-create')){
            $this->holidayService->createHoliday($request);
            return redirect()->back()->with('success','Holiday Added Successfully!');
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
     * Show the form for editing the holiday resource by directing to holidayService.
     *
     * @author Akash Chandra Debnath
     * @method edit
     * @param  \Illuminate\Http\Request  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if(Auth::user()->can('holiday-edit')){
            return $this->holidayService->editHoliday($id);
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Update the specified holiday resource in storage by directing to holidayService.
     *
     * @author Akash Chandra Debnath
     * @method update
     * @param  \Illuminate\Http\Request  $request holiday_date, reason/description
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        if(Auth::user()->can('holiday-edit')){
            $this->holidayService->updateHoliday($request);
            return redirect()->back()->with('success','Holiday Updated Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }


    /**
     * Remove the specified holiday resource from storage by directing to holidayService.
     *
     * @author Akash Chnadra Debnath
     * @param  int  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(Auth::user()->can('holiday-delete')){
            $this->holidayService->deleteHoliday($id);
            return redirect()->back()->with('fail','Holiday Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

}
