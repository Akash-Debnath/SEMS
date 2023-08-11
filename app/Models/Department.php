<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = ['dept_code', 'dept_name', 'isSlot', 'active'];


    public function employee()
    {
        return $this->hasMany(Employee::class, 'dept_code', 'dept_code')->orderBy('emp_id', 'asc');
    }

    // public function designation()
    // {
    //     return $this->hasMany(Designation::class, 'dept_code', 'dept_code');
    // }
}
