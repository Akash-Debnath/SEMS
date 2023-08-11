<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Services\EvaluationService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class EvaluationController extends Controller
{

    /**
     * @var evaluationService
     */
    protected $evaluationService;
    protected $employeeService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(EvaluationService $evaluationService, EmployeeService $employeeService)
    {
        $this->evaluationService = $evaluationService;
        $this->employeeService = $employeeService;
      
    }


    /**
     * Display a listing of all evaluation of specified employee.
     *
     * @author Akash Chandra Debnath
     * @param $id evaluation_id 
     * @return \Illuminate\Http\Response
    */
    public function index($id)
    {
        if(Auth::user()->can('employee-self-evaluation') && Auth::user()->username == $id){
            $empInfo = $this->evaluationService->getEmployeeInfo($id);
            $allEvaluation = $this->evaluationService->getAllEvaluation($id);
            return view('evaluation', compact('empInfo', 'allEvaluation'));
        } elseif(Auth::user()->can('employee-evaluation')) {
            $empInfo = $this->evaluationService->getEmployeeInfo($id);
            $allEvaluation = $this->evaluationService->getAllEvaluation($id);
            return view('evaluation', compact('empInfo', 'allEvaluation'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }



    /**
     * Store a newly created evaluation details of specified employee in storage by directing to evaluationService.
     *
     * @author Akash Chandra Debnath
     * @method store
     * @param  \Illuminate\Http\Request  $request evaluation details data
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(Auth::user()->can('evaluation-create')){
            $empID = $request->emp_id;
            $this->evaluationService->createEvaluation($request);
            return Redirect::to('evaluation-details/'.$empID)->with('success', 'Evaluation Submitted Successfully!');
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Display the specified employee previous evaluation.
     *
     * @author Akash Chandra Debnath
     * @method show
     * @param  string  $id employee_id
     * @return \Illuminate\Http\Response
     * @todo check whether 'evaluation-form.blade.php' missing any attribute
    */
    public function show($id, $empId)
    {
        if(Auth::user()->can('employee-self-evaluation') && Auth::user()->username == $id){
            $empInfo = $this->evaluationService->getEmployeeInfo($empId);
            $evaluationInfo = $this->evaluationService->getEvaluationInfo($id);
            return view('evaluation-form', compact('evaluationInfo', 'empInfo'));
        } elseif(Auth::user()->can('employee-evaluation')) {
            $empInfo = $this->evaluationService->getEmployeeInfo($empId);
            $evaluationInfo = $this->evaluationService->getEvaluationInfo($id);
            return view('evaluation-form', compact('evaluationInfo', 'empInfo'));
        } else {
            return redirect()->back()->with('fail', 'You are not able to go through!');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
