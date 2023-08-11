<?php
namespace App\Services;


use App\Repositories\HolidayRepository;
use Illuminate\Support\Facades\Validator;

class HolidayService 
{

    /**
     * @var holidayRepository
    */
    protected $holidayRepository;


    /**
     * UserService constructor.
     * @param HolidayRepository $holidayRepository
     */
    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }


    /**
     * Display a listing of all holidays for a specific year by directing to holidayRepository.
     *
     * @author Akash Chandra Debnath
     * @method searchHoliday
     * @param $request selected_year
     * @return void
    */
    public function searchHoliday($request)
    {
        return $this->holidayRepository->searchHoliday($request);
    }


    /**
     * Validate date and description and store a newly created holiday resource in storage by directing to holidayRepository.
     *
     * @author Akash Chandra Debnath
     * @method createHoliday
     * @param  \Illuminate\Http\Request  $request holiday_date, reason/description
     * @return \Illuminate\Http\Response
    */
    public function createHoliday($request)
    {
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->holidayRepository->createHoliday($request); 
    }


    /**
     * Show the form for editing the holiday resource by directing to holidayRepository.
     *
     * @author Akash Chandra Debnath
     * @method editHoliday
     * @param  \Illuminate\Http\Request  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function editHoliday($id)
    {   
        $data = $this->holidayRepository->editHoliday($id);
        
        return response()->json([
            'status'=>200,
            'holidays'=>$this->holidayRepository->editHoliday($id)
        ]);
    }
   

    /**
     *  Validate date and description and update the specified holiday resource in storage by directing to holidayRepository.
     *
     * @author Akash Chandra Debnath
     * @method updateHoliday
     * @param  \Illuminate\Http\Request  $request holiday_date, reason/description
     * @return \Illuminate\Http\Response
    */
    public function updateHoliday($request)
    {
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->holidayRepository->updateHoliday($request); 
    }


    /**
     * Remove the specified holiday resource from storage by directing to holidayRepository.
     *
     * @author Akash Chnadra Debnath
     * @method deleteHoliday
     * @param  int  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function deleteHoliday($id)
    {
        return $this->holidayRepository->deleteHoliday($id); 
    }

}