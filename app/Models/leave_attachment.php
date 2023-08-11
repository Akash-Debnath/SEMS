<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_attachment extends Model
{
    use HasFactory;

    protected $fillable = ['leave_id', 'file_name','original_file_name'];
}
