<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attach_msg extends Model
{
    use HasFactory;
    protected $fillable = ['subject', 'message', 'message_date', 'read_by', 'message_from', 'message_to', 'custom_recipient', 'is_encrypted'];


    /**
     * Many to many relationship between `attch_msgs` and `employees` table on employee_id
     * @author Akash Chandra Debnath
    */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'message_from', 'emp_id');
    }



    /**
     * One to many relationship between `attach_msgs` and `attach_files` table
     * @author Akash Chandra Debnath 
    */
    public function attachFiles(){
        return $this->hasMany(Attach_file::class, 'attachment_id', 'id');
    }
}
