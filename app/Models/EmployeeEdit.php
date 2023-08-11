<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEdit extends Model
{
    use HasFactory;
    protected $table = "employee_edits";
    protected $fillable = ['emp_id', 'mobile', 'phone', 'present_address', 'permanent_address', 'last_edu_achieve', 'experiance', 'dob', 'blood_group', 'gender', 'status'];


    /**
     * @author Akash Chandra Debnath
     * @method employee
     * @Eloquent relation (one to one)
    */

    public function employee()
    {
        return $this->hasOne(Employee::class, 'emp_id', 'emp_id');
    }
}
