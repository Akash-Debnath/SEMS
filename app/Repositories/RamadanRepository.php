<?php

namespace App\Repositories;

use App\Models\Ramadan;
use App\Models\RamadanOfficeTime;

class RamadanRepository implements RepositoryInterface
{
    
    /**
     * Display a listing of all the resource of ramadans from `ramdan_office_times` table.
     *
     * @author Akash Chandra Debnath
     * @method getAllRamadanList
     * @return \Illuminate\Http\Response
    */
    public function getAllRamadanList()
    {
       return RamadanOfficeTime::paginate(20);
    }



    /**
     * Store a newly created ramdan resource in storage from `ramdan_office_times` table.
     *
     * @author Akash Chandra Debnath
     * @method createRamadan
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function createRamadan($data)
    {
        return RamadanOfficeTime::create(['date_from'=>$data->date_from, 'date_to'=>$data->date_to, 'stime' => $data->stime, 'etime' => $data->etime])->save();
    }


    /**
     * Get data editing the specified ramadan resource from `ramdan_office_times` table.
     *
     * @author Akash Chandra Debnath
     * @method editRamadan
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function editRamadan($id)
    {
        return RamadanOfficeTime::where('id',$id)->first();
    }


    /**
     * Update the specified ramdan resource from `ramdan_office_times` table.
     *
     * @author Akash Chandra Debnath
     * @method updateRamadan
     * @param  \Illuminate\Http\Request  $request
     * @param   $request start_date, end_date, start_time, end_time
     * @return \Illuminate\Http\Response
    */
    public function updateRamadan($request)
    {
        $data = $request->input('ramadanId');
        return RamadanOfficeTime::where('id', $data)->update(['date_from'=>$request->date_from, 'date_to'=>$request->date_to, 'stime' => $request->stime, 'etime' => $request->etime]);
    }



    /**
     * Remove the specified ramdan resource from `ramdan_office_times` table.
     *
     * @author Akash Chandra Debnath
     * @method deleteRamadan
     * @param  int  $id ramadan_time_id
     * @return \Illuminate\Http\Response
    */
    public function deleteRamadan($id)
    {
        return RamadanOfficeTime::findorFail($id)->delete();
    }


    public function all()
    {
        return true;
    }


    public function get($id)
    {
        return true;
    }




    public function create(array $data)
    {
        return true;
    }



    public function update(array $data, $id)
    {
        return true;
    }



    public function delete($id)
    {
        return true;
    }

}