<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    
   
    protected $fillable = ['emp_id','leave_type','time_slot','leave_start','leave_end','leave_date','m_approved_date','manager_remark','period','address_d_l',
'special_reason','comment1','comment2','comment3','admin_approve_date','admin_remark','leave_approval','send_to','cancel_req_date','cancel_approve_date','manager_id','admin_id', ];


public function employee(){
    return $this->hasMany(Employee::class , 'emp_id' ,'emp_id');
}
  
}
