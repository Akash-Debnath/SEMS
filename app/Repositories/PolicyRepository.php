<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\Policy;
use App\Models\PolicyFile;

class PolicyRepository implements RepositoryInterface
{


    /**
     * Get all policy from `policies` table.
     * 
     * @author Akash Chandra Debnath
     * @method getAllPolicy
     * @relationship with `policy_files` table
     * @return all_policy
    */
    public function getAllPolicy()
    {
        return Policy::with('policyFile')->orderBy('id', 'DESC')->paginate(20);
    }



    /**
     * Store newly created policy in `policies` table.
     * 
     * @author Akash Chandra Debnath
     * @method createPolicy
     * @return policy_id
    */
    public function createPolicy($data)
    {
        $policy = Policy::create(['policy_title' => $data->policy_title]);
        return  $policy->id;
    }



    /**
     * Remove specified policy from `policies` table.
     * 
     * @author Akash Chandra Debnath
     * @method deletePolicy
     * @return void
    */
    public function deletePolicy($id)
    {
        $policy = Policy::findorFail($id);
        return $policy->delete();
    }



    /**
     * Store new policy files in `policy_files` table.
     * 
     * @author Akash Chandra Debnath
     * @method createPolicyfile
     * @return void
    */
    public function createPolicyfile($data,$policyId)
    {   
        if($data->hasfile('file_name'))
        {  
            $file = $data->file('file_name');
            // $name = time().rand(1,100).'.'.$file->extension();
            $name=$file->getClientOriginalName();
            $file->move(public_path('PolicyFiles'), $name);  
            $policy= new PolicyFile();
            $policy->file_name =  $name; 
            $policy->policy_id =  $policyId; 
            $policy->save();  
        }
        return;
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