<?php

namespace App\Repositories;

use App\Models\FacilityOption;
use Illuminate\Support\Facades\Auth;

class FacilityRepository implements RepositoryInterface
{
    
    public function getAllFacility()
    {
       return FacilityOption::paginate(20);
    }


    public function createFacility($data)
    {
        return FacilityOption::create(['facility' => strtoupper($data->facility), 'description'=>$data->description])->save();
    }


    public function editFacility($id)
    {
        return FacilityOption::where('id',$id)->first();
    }



    public function updateFacility($request)
    {

        $data = $request->input('facilityId');
        return FacilityOption::where('id', $data)->update(['facility'=>strtoupper($request->facility), 'description'=>$request->description]);
    
    }


    public function deleteFacility($id)
    {
        return FacilityOption::findorFail($id)->delete();
        // return $facility->delete();
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