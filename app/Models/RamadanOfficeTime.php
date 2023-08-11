<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamadanOfficeTime extends Model
{
    use HasFactory;
    protected $table = 'ramadan_office_times';
    protected $fillable = ['date_from', 'date_to', 'stime', 'etime'];
}
