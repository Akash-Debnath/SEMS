<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";
    protected $fillable = ['emp_id', 'dept_code', 'type'];



    public function employee()
    {
        return $this->hasOne(Employee::class, 'emp_id', 'emp_id');
    }

}
