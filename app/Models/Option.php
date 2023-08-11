<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['option_name','option_code','option_value','leave_m','leave_f','roster_dept','stime','etime','leave_days','prescription'];
}
