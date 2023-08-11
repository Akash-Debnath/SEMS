<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attach_file extends Model
{
    use HasFactory;

    protected $tables = 'attach_files';
    protected $fillable = ['attachment_id', 'filename'];


    public function setFilenamesAttribute($value)
    {
        $this->attributes['filename'] = json_encode($value);
    }


    public function policy()
    {
        return $this->hasOne(Policy::class, 'id', 'id');
    }

   
}
