<?php

namespace App\Http\Controllers;

use App\Services\Late_early_reqService;
use Illuminate\Http\Request;
use App\Models\late_early_req;
use App\Models\Employee;
use DateTime;
use Illuminate\Support\Facades\Auth;

class Late_early_reqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // late-early-pending-req

    protected $Late_early_reqService;

    public function __construct(Late_early_reqService $Late_early_reqService)
    {
        $this->Late_early_reqService = $Late_early_reqService;
    }

    public function index()
    {
        if (Auth::user()->can('dashboard-attendance-lateEarlyPending')) {


            $employee = $this->Late_early_reqService->getEmployee();
            $approve = $this->Late_early_reqService->approvalReq();
            $verify = $this->Late_early_reqService->verifyReq();
            $ac = $approve->count();
            $ve = $verify->count();
            return view('late-early-pending-req', compact('approve', 'ac', 'verify', 've', 'employee'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    public function approve($id)
    {

        if (Auth::user()->can('lateEarly-approval-approve-refuse')) {
            $this->Late_early_reqService->approve($id);
            return redirect()->back()->with('success', 'Request Approved Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    public function verify($id)
    {
        if (Auth::user()->can('lateEarly-verification-approve-refuse')) {
            $this->Late_early_reqService->verify($id);
            return redirect()->back()->with('success', 'Request Verified Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  late-early-req
    public function late_early_req()
    {
        if (Auth::user()->can('dashboard-attendance-lateEarly')) {
            return view('late-early-req');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
    }


    /**
     * Store late/early request by directing to Late_early_reqService
     * @author Tahrim Kabir
     * @modified by Akash Chandra Debnath 
     */
    public function create(Request $req)
    {
        if (Auth::user()->can('dashboard-attendance-lateEarly')) {
            $this->Late_early_reqService->create_Request($req);
            return redirect()->back()->with('success', 'Late/early Request Sent Successfully');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through');
        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // late_early_req::where('id',$id)->delete();
        $this->Late_early_reqService->delete($id);
        return redirect()->back()->with('fail', 'Late/early Request has been deleted Successfully!');
    }
}
