<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPermission extends Model
{
    use HasFactory;

    protected $table = 'activity_permissions';
    // protected $fillable = ['id', 'activity_id', 'staff_id'];
}
