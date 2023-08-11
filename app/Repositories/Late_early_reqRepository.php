<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Models\late_early_req;
use App\Models\Employee;
use DateTime;
use Illuminate\Support\Facades\Auth;

class Late_early_reqRepository implements RepositoryInterface{
    public function getEmployee(){
        return Employee::all();
    }

    public function approvalReq(){
        return late_early_req::where('approved', 'N')->where('verified', 'N')->get();
    }

    public function verifyReq(){
        return late_early_req::where('verified', 'N')->where('approved', 'Y')->get();
    }

    public function approve($id){
        $get = late_early_req::where('id', $id)->get();

        foreach ($get as $g) {
            $data = array('approved' => 'Y', 'approved_time' => date('Y-m-d H:i:s'), 'approved_by' => Auth::user()->employeeInfo->emp_id);
            late_early_req::where('id', $id)->update($data);
        }

        return;
    }

    public function verify($id)
    {

        $get = late_early_req::where('id', $id)->get();

        foreach ($get as $g) {
            $data = array('verified' => 'Y', 'verified_time' => date('Y-m-d H:i:s'), 'verified_by' => Auth::user()->employeeInfo->emp_id);
            late_early_req::where('id', $id)->update($data);
        }

        return ;
    }

    
    public function create_Request($req){
        $late = $req->late;
        $early = $req->early;
        $absent = $req->absent;
        $special = $req->special;
        $date = $req->date;
        $reason = $req->reason;
        $emp_id = Auth::user()->employeeInfo->emp_id;

        if (empty($late)) {
            $late = "N";
        }
        if (empty($early)) {
            $early = "N";
        }
        if (empty($absent)) {
            $absent = "N";
        }
        if (empty($special)) {
            $special = "N";
        }
        $data = array(

            'emp_id' => $emp_id,

            'date' => $req->date,
            'late_req' => $late,
            'early_req' => $early,
            'absent_req' => $absent,
            'special_req' => $special,
            'reason' => $req->reason,

        );

        late_early_req::create($data);

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
        return late_early_req::where('id',$id)->delete();
    }
}
