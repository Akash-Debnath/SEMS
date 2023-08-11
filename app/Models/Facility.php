<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $table = 'facilities';
    protected $fillable = ['emp_id', 'facility', 'description', 'from_date', 'to_date', 'facility_id'];
}
