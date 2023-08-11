<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Incident;

class IncidentRepository implements RepositoryInterface
{

    /**
     * Get all incidents and show 20 incidents in each page from `incidents` table by Model - Incident
     *
     * @author Akash Chandra Debnath
     * @method getAllIncident
     * @return void
    */
    public function getAllIncident()
    {
        return Incident::paginate(20);
    }


    /**
     * Store incidents data in `incidents` table by Model - Incident.
     *
     * @author Akash Chandra Debnath
     * @method createIncident
     * @param $data incident_start_date, incident_end_date, incident_description
     * @return void
    */
    public function createIncident($data)
    {
        return Incident::create([ 'date' => $data->date, 'description' => $data->description])->save();
    }


    /**
     * Get row data find with id from `incidents` table.
     *
     * @author Akash Chandra Debnath
     * @method editIncident
     * @param int $id incident_id
     * @return void
    */
    public function editIncident($id)
    {
        return Incident::where('id',$id)->first();
    }


    /**
     * Update incidents for requesting id data in `incidents` table
     *
     * @author Akash Chandra Debnath
     * @method updateIncident
     * @param $request incident_start_date, incident_end_date, incident_description
     * @return void
    */
    public function updateincident($request)
    {
        $data = $request->input('incidentId');
        return Incident::where('id', $data)->update(['date'=>$request->date, 'description'=>$request->description]);
    }



    /**
     * Remove incident with incident_id from `incidents` table.
     *
     * @author Akash Chandra Debnath
     * @method deleteIncident
     * @param $id incident_id
     * @return void
    */
    public function deleteIncident($id)
    {
        return Incident::findorFail($id)->delete();
    }


    /**
     * Get all incidents of specified year
     * 
     * @author Akash Chandra Debnath
     * @method searchIncident
     * @return incidents of requested year
     */
    public function searchIncident($request)
    {
        $year = $request->date_year;
        return Incident::whereYear('date', $year)->paginate(20);
        // dd($ab);

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