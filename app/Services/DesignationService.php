<?php
namespace App\Services;

use App\Repositories\DesignationRepository;
use Illuminate\Support\Facades\Validator;

class DesignationService 
{

    /**
     * @var designationRepository
    */
    protected $designationRepository;


    /**
     * UserService constructor.
     * @param designationRepository $designationRepository
     */
    public function __construct(DesignationRepository $designationRepository)
    {
        $this->designationRepository = $designationRepository;
    }



    public function getAllDesignation()
    {
        return $this->designationRepository->getAllDesignation(); 
    }


    public function getEmployeeDepartment()
    {
        return $this->designationRepository->getEmployeeDepartment();
    }


    public function createDesignation($request)
    {

        // $request -> validate([
        //     'dept_code' => 'required', 
        //     'designation' => 'required'
        // ]);
        $validator = Validator::make($request->all(),[
            'dept_code' => 'required', 
            'designation' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->designationRepository->createDesignation($request); 
    }


    public function editDesignation($id)
    {   
        $data = $this->designationRepository->editDesignation($id);
        
        return response()->json([
            'status'=>200,
            'designation'=>$this->designationRepository->editDesignation($id)
        ]);
    }



    public function updateDesignation($request)
    {

        $validator = Validator::make($request->all(),[
            'dept_code' => 'required', 
            'designation' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->designationRepository->updateDesignation($request); 
    }



    public function deleteDesignation($id)
    {
        return $this->designationRepository->delete($id); 
    }


}