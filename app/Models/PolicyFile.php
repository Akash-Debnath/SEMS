<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyFile extends Model
{
    use HasFactory;

    protected $table = 'policyfiles';
    protected $fillable = ['policy_id', 'file_name'];
}
