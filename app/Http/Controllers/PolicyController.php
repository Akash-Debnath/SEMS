<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PolicyService;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    /**
     * @var policyService
    */
    protected $policyService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function __construct(PolicyService $policyService)
    {
        $this->policyService = $policyService;
    }


    /**
     * Display a listing of the policy resource by directing to policyService.
     *
     * @author Akash Chandra Debnath
     * @method index
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policy= $this->policyService->getAllPolicy();
        return view('policy', compact('policy'));
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
     * Store a newly created policy resource in storage by directing to policyService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request policy_title, policy_file
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('policy-create')){
            $policy = $this->policyService->createPolicy($request);
            return redirect()->route('policy.index')->with('success','Policy Added Successfully!');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage by directing to policyService.
     *
     * @author Akash Chandra Debnath
     * @method destroy
     * @param  int  $id policy_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('policy-delete')){
            $this->policyService->deletePolicy($id);
            return redirect()->route('policy.index')->with('fail','Policy Deleted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }

    /**
     * Download ems policy and save in 'policyFiles' 
     * 
     * @author Akash Chandra Debnath
     * @method downloadPolicy
     */
    public function downloadPolicy(Request $request, $filename)
    {
        $pathToFile = storage_path('policyFiles/' .$filename);
        return response($pathToFile);
        // return response()->download(public_path('PolicyFiles/'.$filename));
    }
}
