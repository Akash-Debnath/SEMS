<?php
namespace App\Services;

use App\Repositories\OfficeTimeRepository;
use Illuminate\Support\Facades\Validator;

class OfficeTimeService 
{

    /**
     * @var officeTimeRepository
    */
    protected $officeTimeRepository;


    /**
     * UserService constructor.
     * @param officeTimeRepository $officeTimeRepository
     */
    public function __construct(OfficeTimeRepository $officeTimeRepository)
    {
        $this->officeTimeRepository = $officeTimeRepository;
    }


    public function getAllEmployee()
    {
        return $this->officeTimeRepository->all();
    }


    public function getAllWeekLeaves()
    {
        return $this->officeTimeRepository->getAllWeekLeaves();
    }


    public function getAllDepartment()
    {
        return $this->officeTimeRepository->getAllDepartment();
    }


    public function updateSchedule($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'scheduled_attendance' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->officeTimeRepository->updateSchedule($request, $id);
    }


    public function updateRoster($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'roster' => 'required', 
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        return $this->officeTimeRepository->updateRoster($request, $id);
    }

}