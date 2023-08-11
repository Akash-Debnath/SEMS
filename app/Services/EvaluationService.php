<?php
namespace App\Services;

use App\Repositories\EvaluationRepository;
use Illuminate\Support\Facades\Validator;

class EvaluationService 
{

    /**
     * @var evaluationRepository
    */
    protected $evaluationRepository;


    /**
     * UserService constructor.
     * @param evaluationRepository $evaluationRepository
     */
    public function __construct(EvaluationRepository $evaluationRepository)
    {
        $this->evaluationRepository = $evaluationRepository;
    }


    /**
     * Display the specified employee evaluation by directing to evaluationRepository.
     *
     * @author Akash Chandra Debnath
     * @method getEmployeeInfo
     * @param  int  $id employee_id
     * @return \Illuminate\Http\Response
    */
    public function getEmployeeInfo($id)
    {
        return $this->evaluationRepository->getEmployeeInfo($id); 
    }



    /**
     * Validate requested evaluation details and  store in storage by directing to evaluationRepository.
     *
     * @author Akash Chandra Debnath
     * @method createEvaluation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @todo must field 
    */
    public function createEvaluation($request)
    {

        $validator = Validator::make($request->all(),[
            'emp_id' => 'required',  
            'eve_from' => 'required', 
            'eve_to' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->evaluationRepository->createEvaluation($request); 
    }


    /**
     * To get all previious evaluation history
     * 
     * @author Akash Chandra Debnath
     * @method getAllEvaluation
     * @param $id employee_id
     * @return void
     */
    public function getAllEvaluation($id)
    {
        return $this->evaluationRepository->getAllEvaluation($id); 
    }


    /**
     * Get all evaluation details by directing to evaluationRepository.
     * 
     * @author Akash Chandra Debnath
     * @method getEvaluationInfo
     * @param $id evaluation_id
     * @return void 
    */
    public function getEvaluationInfo($id)
    {
        return $this->evaluationRepository->getEvaluationInfo($id);
    }

}