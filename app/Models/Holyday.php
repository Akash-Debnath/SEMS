<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holyday extends Model
{
    use HasFactory;

    protected $table='holydays';
    protected $fillable = ['date', 'description'];

   
   
    
}
