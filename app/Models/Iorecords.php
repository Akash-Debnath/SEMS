<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iorecords extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id','stime','etime','date','system_fault'];

    
}
