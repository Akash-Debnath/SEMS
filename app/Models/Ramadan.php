<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ramadan extends Model
{
    use HasFactory;
    protected $table = 'ramadans';
    protected $fillable = ['stime', 'etime'];
}
