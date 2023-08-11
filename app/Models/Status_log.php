<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_log extends Model
{
    use HasFactory;
    protected $table = 'status_logs';
    protected $fillable = ['emp_id', 'status', 'date'];


    public function employee()
    {
        return $this->hasMany(Employee::class, 'status');
    }
}
