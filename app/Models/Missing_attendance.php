<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missing_attendance extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id','date','in','out','reason','status','m_approved_date','a_verified_date','manager_id','admin_id'];
}
