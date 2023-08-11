<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Late_early_req extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','date','late_req','early_req','absent_req','special_req','reason','approved','approved_time','approved_by','verified','verified_time',
'verified_by'];

    public function employee(){
        return $this->belongsTo(late_early_req::class,'emp_id','emp_id');
    }
}
