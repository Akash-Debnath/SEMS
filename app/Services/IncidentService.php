<?php
namespace App\Services;


use App\Repositories\IncidentRepository;
use Illuminate\Support\Facades\Validator;

class IncidentService 
{

    /**
     * @var incidentRepository
    */
    protected $incidentRepository;


    /**
     * UserService constructor.
     * @param IncidentRepository $incidentRepository
    */
    public function __construct(IncidentRepository $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    

    /**
     * Display all incidents by directing to incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method getAllIncident
     * @return void
    */
    public function getAllIncident()
    {
        return $this->incidentRepository->getAllIncident();
    }


    /**
     * Validate incidents data and store by directing to incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method createIncident
     * @param $request incident_start_date, incident_end_date, incident_description
     * @return void
    */
    public function createIncident($request)
    {
        $validator = Validator::make($request->all(),[
            'description' => 'required', 
            'date' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->incidentRepository->createIncident($request); 
    }


    /**
     * Show the form for editing by directing to incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method editIncident
     * @param int $id incident_id
     * @return void
    */
    public function editIncident($id)
    {   
        $data = $this->incidentRepository->editIncident($id);
        

        return response()->json([
            'status'=>200,
            'incident'=>$this->incidentRepository->editIncident($id)
        ]);
    }


    /**
     * Update incidents with validating data and redirect to incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method updateIncident
     * @param $request incident_start_date, incident_end_date, incident_description
     * @return void
    */
    public function updateIncident($request)
    {
        $validator = Validator::make($request->all(),[
            'date' => 'required', 
            'description' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        $this->incidentRepository->updateIncident($request); 
    }


    /**
     * Remove incident with incident_id by redirecting incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method deleteIncident
     * @param $id incident_id
     * @return void
    */
    public function deleteIncident($id)
    {
        return $this->incidentRepository->deleteIncident($id); 
    }

   
    /**
     * Search incidents data with specific year by directing to incidentRepository.
     *
     * @author Akash Chandra Debnath
     * @method searchIncident
     * @param $request selected_year
     * @return void
    */
    public function searchIncident($request)
    {
        return $this->incidentRepository->searchIncident($request);
    }


}