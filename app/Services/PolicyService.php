<?php
namespace App\Services;


use App\Repositories\PolicyRepository;
use Illuminate\Support\Facades\Validator;

class PolicyService 
{

    /**
     * @var policyRepository
    */
    protected $policyRepository;


    /**
     * UserService constructor.
     * @param PolicyRepository $policyRepository
     */
    public function __construct(PolicyRepository $policyRepository)
    {
        $this->policyRepository = $policyRepository;
    }

    public function getAllPolicy()
    {
        return $this->policyRepository->getAllPolicy();
    }


    public function deletePolicy($id)
    {
        return $this->policyRepository->deletePolicy($id); 
    }


    public function createPolicy($request)
    {
        $validator = Validator::make($request->all(),[
            'policy_title' => 'required', 
            // 'file_name' => 'required|mimes:doc,pdf,docx'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $policyId = $this->policyRepository->createPolicy($request); 
        return $this->policyRepository->createPolicyfile($request,$policyId); 
    }


}