<?php

namespace App\Services;

use App\Repositories\JobDescriptionRepository;
use Illuminate\Support\Facades\Validator;

class JobDescriptionService
{
    /**
     * @var jobDescRepository
     */
    protected $jobDescRepository;


    /**
     * UserService constructor.
     * @param JobDescriptionRepository $jobDescRepository
     */
    public function __construct(JobDescriptionRepository $jobDescRepository)
    {
        $this->JobDescriptionRepository = $jobDescRepository;
    }

    /**
     * @author Tahrim Kabir
     * @return departments
    */
    public function getDepartment()
    {
        return $this->JobDescriptionRepository->getDepartment();
    }


    public function getEmployee()
    {
        return $this->JobDescriptionRepository->getEmployee();
    }


    public function store($request)
    {
        return $this->JobDescriptionRepository->store($request);
    }


    public function editJobDesc($id)
    {
        // dd($id);
        $data = $this->JobDescriptionRepository->editJobDesc($id);
        return response()->json([
            'status' => 200,
            'job_desc_files' => $this->JobDescriptionRepository->editJobDesc($id)
        ]);
    }


    public function updateJobDesc($request)
    {
        $this->JobDescriptionRepository->updateJobDesc($request);
    }
}
