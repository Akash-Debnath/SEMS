<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $option=Option::all();
       return view('setting',compact('option'));
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
        $data = array('stime'=>$request->stime,'etime'=>$request->etime);
       
        $query = Option::where('option_name','default_time')->update($data);
        return redirect()->route('setting.index');
    }



    public function weekend(Request $req, $id){
        $data =array('option_value'=>$req->day);
      
        $query=Option::where('option_id',$id)->update($data);
        return redirect()->route('setting.index');
    }


    public function cmnLeave(Request $req, $id){
        $data = array('leave_m'=>$req->ldays,'leave_f'=>$req->ldays);
        $query=Option::where('option_id',$id)->update($data);
        return redirect()->route('setting.index');
    }


    public function fmLeave(Request $req, $id){
        $data = array('leave_m'=>$req->ldays_m,'leave_f'=>$req->ldays_f);
        $query=Option::where('option_id',$id)->update($data);
        return redirect()->route('setting.index');
    }

    public function addLeave(Request $req){
        // $full = $req->fullForm;
        // $short = $req->shortForm;
        // $days=$req->days;
        // $presc = $req->ispresc;

        $data = array('option_name'=>'leave_type','option_code'=>$req->shortForm,'option_value'=>$req->fullForm,'leave_m'=>$req->days,'leave_f'=>$req->days,'prescription'=>$req->ispresc);
        $query = Option::create($data);
        return redirect()->route('setting.index');
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

        $query = Option::where('option_id',$id)->delete();
        // dd($query);
        // return redirect()->route('setting.index');
        return view('setting');
    }
}
