<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Holyday;

class HolidayRepository implements RepositoryInterface
{

    /**
     * Fetch holidays from `holidays` table filter by requested year
     * 
     * @author Akash Chandra Debnath
     * @method searchHoliday
     * @param $request
     * @return holidays of requested year
    */
    public function searchHoliday($request)
    {
        $data = [];
        $selectedYear = $request->date_year;
        $today = date('Y-m-d');
        $data['remaining'] = 0;
        $data['spent'] = 0;

       $data['holidays'] =  Holyday::whereYear('date',$selectedYear)->orderBy('date', 'ASC')->paginate(20);
       $data['totalholidays'] = count($data['holidays']);

       foreach($data['holidays'] as $hd)
       {
            if($today > $hd->date)
            {
                $data['spent']++;
            } else{
                $data['remaining']++;
            }
       }
       return $data;
    }


    /**
     * Store new created holidays in `holidays` table
     * 
     * @author Akash Chandra Debnath
     * @method searchHoliday
     * @param $request
     * @return holidays of requested year
    */
    public function createHoliday($data)
    {
        return Holyday::create([ 'date' => $data->date, 'description' => $data->description])->save();
    }


    /**
     * Show the holiday resource for editing from `holidays` table.
     *
     * @author Akash Chandra Debnath
     * @method editHoliday
     * @param  \Illuminate\Http\Request  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function editHoliday($id)
    {
        return Holyday::where('id',$id)->first();
    }


    /**
     * Update the specified holiday resource in  `holidays` table.
     *
     * @author Akash Chandra Debnath
     * @method updateHoliday
     * @param  \Illuminate\Http\Request  $request holiday_date, reason/description
     * @return \Illuminate\Http\Response
    */
    public function updateHoliday($request)
    {
        $data = $request->input('holidayId');
        return Holyday::where('id', $data)->update(['date'=>$request->date, 'description'=>$request->description]);
    }



    /**
     * Remove the specified holiday resource from `holidays` table.
     *
     * @author Akash Chnadra Debnath
     * @method deleteHoliday
     * @param  int  $id holiday_id
     * @return \Illuminate\Http\Response
    */
    public function deleteHoliday($id)
    {
        return Holyday::findorFail($id)->delete();
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