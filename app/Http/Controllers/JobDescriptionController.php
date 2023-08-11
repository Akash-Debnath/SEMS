<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\JobDescriptionService;
use Illuminate\Support\Facades\Auth;

class JobDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $jobdescService;

    public function __construct(JobDescriptionService $jobdescService)
    {
        $this->JobDescriptionService = $jobdescService;
    }


    public function index()
    {    
        $department =  $this->JobDescriptionService->getDepartment();
        $employee = $this->JobDescriptionService->getEmployee();
         
        return view('job-description-board',compact('department','employee'));
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
        if(Auth::user()->can('jobdescription-upload')){
            return $this->JobDescriptionService->store($request); 
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
       $this->JobDescriptionService->editJobDesc($id);
        // return view('job-description-board');
    }
    

    public function update(Request $request )
    {   
        if(Auth::user()->can('jobdescription-change')){
            $this->JobDescriptionService->updateJobDesc($request);
            return redirect()->back()->with('success','Job Description Edited Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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
