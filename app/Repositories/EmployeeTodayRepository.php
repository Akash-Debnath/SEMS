<?php

namespace App\Repositories;

use App\Models\Rostering;
use App\Models\Department;
use App\Models\Iorecords;
use App\Models\Iorecords_temp;
use App\Models\Employee;
use App\Models\Option;

class EmployeeTodayRepository implements RepositoryInterface
{

    /**
     * Get all roster data from `rosterings` data
     * 
     * @author 
     * @method Roster
     */
    public function Roster()
    {
        return Rostering::whereDate('stime', date("Y-m-d", strtotime("2022-08-31")))->get();
    }
    public function  defaultTime()
    {
        return Option::where('option_name', 'default_time')->first();
    }
    public function defaultWeekend(){
        $day = date('l');
        return Option::where('option_code', $day)->first();
    }
    public function Department()
    {
        return Department::all();
    }

    public function Employee()
    {
        return Employee::where('archive', 'N')->get();
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
