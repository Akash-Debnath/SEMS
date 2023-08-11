<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iorecords_temp extends Model
{
    use HasFactory;
    protected $table = 'iorecords_temps';
    protected $fillable = ['emp_id','stime','etime','date','system_fault'];
}
