<?php
namespace App\Services;

use App\Repositories\FacilityRepository;
use Illuminate\Support\Facades\Validator;

class FacilityService 
{

    /**
     * @var facilityRepository
    */
    protected $facilityRepository;


    /**
     * UserService constructor.
     * @param facilityRepository $facilityRepository
     */
    public function __construct(FacilityRepository $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }



    public function getAllFacility()
    {
        return $this->facilityRepository->getAllFacility(); 
    }


    public function createFacility($request)
    {
        $validator = Validator::make($request->all(),[
            'facility' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->facilityRepository->createFacility($request); 
    }


    public function editFacility($id)
    {   
        $data = $this->facilityRepository->editFacility($id);
        

        return response()->json([
            'status'=>200,
            'facilities'=>$this->facilityRepository->editFacility($id)
        ]);
    }



    public function updateFacility($request)
    {
        $validator = Validator::make($request->all(),[
            'facility' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->facilityRepository->updateFacility($request); 
    }



    public function deleteFacility($id)
    {
        return $this->facilityRepository->deleteFacility($id); 
    }


}