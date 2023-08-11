<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityOption extends Model
{
    use HasFactory;

    protected $table = 'facility_options';
    protected $fillable = ['id', 'facility', 'description'];
}
