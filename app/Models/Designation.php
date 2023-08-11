<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designations';
    protected $fillable = ['dept_code', 'designation'];



    public function employee()
    {
        return $this->hasMany(Employee::class, 'designation', 'id');
    }


    // public function department()
    // {
    //     return $this->belongsTo(Department::class, 'dept_code', 'dept_code');
    // }
}
