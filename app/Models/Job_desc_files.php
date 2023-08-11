<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Job_desc_files extends Model
{
    use HasFactory;
    protected $table = 'job_desc_files';
    protected $fillable = ['id', 'emp_id', 'file_name'];
     
}


