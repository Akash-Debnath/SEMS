<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RosterSlot extends Model
{
    use HasFactory;
    protected $table = 'roster_slots';
    protected $fillable = ['dept_code', 'slot_no', 'from', 'to'];
}
