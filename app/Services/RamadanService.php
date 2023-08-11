<?php
namespace App\Services;

use App\Repositories\RamadanRepository;
use Illuminate\Support\Facades\Validator;

class RamadanService 
{

    /**
     * @var ramadanRepository
    */
    protected $ramadanRepository;


    /**
     * UserService constructor.
     * @param ramadanRepository $ramadanRepository
     */
    public function __construct(RamadanRepository $ramadanRepository)
    {
        $this->ramadanRepository = $ramadanRepository;
    }



    /**
     * Display a listing of all the resource of ramadans by directing to ramadanRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllRamadanList
     * @return \Illuminate\Http\Response
    */
    public function getAllRamadanList()
    {
        return $this->ramadanRepository->getAllRamadanList(); 
    }



    /**
     * Validate request data and store a newly created ramdan resource in storage by directing to ramadanRepository.
     *
     * @author Akash Chandra Debnath
     * @method createRamadan
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function createRamadan($request)
    {
        $validator = Validator::make($request->all(),[
            'date_from' => 'required|unique:ramadan_office_times', 
            'date_to' => 'required|unique:ramadan_office_times' 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->ramadanRepository->createRamadan($request); 
    }



    /**
     * Send data as response for editing the specified ramadan resource by directing to ramadanRepository.
     *
     * @author Akash Chandra Debnath
     * @method editRamadan
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function editRamadan($id)
    {   

        return response()->json([
            'status'=>200,
            'ramadann'=>$this->ramadanRepository->editRamadan($id)
        ]);

    }


    /**
     * Validate request data and update the specified ramdan resource in storage by ramadanRepository.
     *
     * @author Akash Chandra Debnath
     * @method updateRamadan
     * @param  \Illuminate\Http\Request  $request
     * @param   $request start_date, end_date, start_time, end_time
     * @return \Illuminate\Http\Response
    */
    public function updateRamadan($request)
    {
        $validator = Validator::make($request->all(),[
            'date_from' => 'required', 
            'date_to' => 'required' 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->ramadanRepository->updateRamadan($request); 
    }


    /**
     * Remove the specified ramdan resource from storage by directing to ramadanRepository.
     *
     * @author Akash Chandra Debnath
     * @method deleteRamadan
     * @param  int  $id ramadan_time_id
     * @return \Illuminate\Http\Response
    */
    public function deleteRamadan($id)
    {
        return $this->ramadanRepository->deleteRamadan($id); 
    }


}