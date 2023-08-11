<?php

namespace App\Repositories;

use App\Models\Evaluation;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EvaluationRepository implements RepositoryInterface
{

    /**
     * Get the specified employee evaluation from `evaluations` table by constructing hasOne relationship with `employees` table.
     *
     * @author Akash Chandra Debnath
     * @method getEmployeeInfo
     * @param  string  $id employee_id
     * @return void
    */
    public function getEmployeeInfo($id)
    {
        // return Employee::where('emp_id', '=', $id)->with('evaluationOne')->first();
        return Employee::where('emp_id', '=', $id)->first();
    }



    /**
     * Get all evaluation details from `evaluations` and get data from `employees` table.
     * 
     * @author Akash Chandra Debnath
     * @method getEvaluationInfo
     * @method getEvaluationInfo
     * @param $id evaluation_id
     * @return void 
    */
    public function getEvaluationInfo($id)
    {
        return Evaluation::where('id', '=', $id)->with('employee')->first();
    }

    

    /**
     * Store requested evaluation details in `evaluations` table.
     *
     * @author Akash Chandra Debnath
     * @method createEvaluation
     * @param  \Illuminate\Http\Request  $request
     * @return void
    */
    public function createEvaluation($request)
    {
        $eva = new Evaluation;
        $eva->emp_id = $request->emp_id;
        $eva->eve_from = $request->eve_from;
        $eva->eve_to = $request->eve_to;
        $eva->ksa = $request->ksa;
        $eva->ksa_comments = $request->ksa_comments;
        $eva->qlw = $request->qlw;
        $eva->qlw_comments = $request->qlw_comments;
        $eva->qtw = $request->qtw;
        $eva->qtw_comments = $request->qtw_comments;
        $eva->wh = $request->wh;
        $eva->wh_comments = $request->wh_comments;
        $eva->com = $request->com;
        $eva->com_comments = $request->com_comments;
        $eva->dep = $request->dep;
        $eva->dep_comments = $request->dep_comments;
        $eva->coo = $request->coo;
        $eva->coo_comments = $request->coo_comments;
        $eva->ini = $request->ini;
        $eva->ini_comments = $request->ini_comments;
        $eva->ada = $request->ada;
        $eva->ada_comments = $request->ada_comments;
        $eva->jud = $request->jud;
        $eva->jud_comments = $request->jud_comments;
        $eva->att = $request->att;
        $eva->att_comments = $request->att_comments;
        $eva->pun = $request->pun;
        $eva->pun_comments = $request->pun_comments;
        $eva->led = $request->led;
        $eva->led_comments = $request->led_comments;
        $eva->del = $request->del;
        $eva->del_comments = $request->del_comments;
        $eva->pla = $request->pla;
        $eva->pla_comments = $request->pla_comments;
        $eva->adm = $request->adm;
        $eva->adm_comments = $request->adm_comments;
        $eva->per = $request->per;
        $eva->per_comments = $request->per_comments;
        $eva->opr = $request->opr;
        $eva->opr_comments = $request->opr_comments;
        $eva->hbf = $request->hbf;
        $eva->hbf_comments = $request->hbf_comments;
        // $eva->avg_rate = $request->avg_rate;
        // $eva->man_sig_date = $request->man_sig_date;
        // $eva->manager_id = $request->manager_id;
        $eva->emp_sig_date = $request->emp_sig_date;
        $eva->emp_comments = $request->emp_comments;
        $eva->admin_sig_date = $request->admin_sig_date;
        $eva->admin_comments = $request->admin_comments;
        $eva->admin_id = $request->admin_id;
        // $eva->status = $request->status;

        // if($request->hasfile('emp_attachment'))
        // {  
        //     $file = $request->file('emp_attachment');
        //     $name =$file->getClientOriginalName();
        //     $file->move(public_path('EmployeePhoto'), $name);
        //     $e->emp_attachment = $name; 
        // }
        return $eva->save(); 
    }



    /**
     * previous evaluation list of corresponding employee from `evaluations` table
     * 
     * @author Akash Chandra Debnath
     * @method getAllEvaluation
     * @param $id employee_id
     * @return evaluation_details 
     */
    public function getAllEvaluation($id)
    {
        return Evaluation::where('emp_id','=',$id)->get();
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