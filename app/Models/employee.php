<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'emp_id',
        'name',
        'dept_code',
        'designation',
        'mobile',
        'phone',
        'email',
        'jdate',
        'dob',
        'gender',
        'status',
        'grade_id',
        'blood_group',
        'image',
        'pass',
        'cur_status',
        'status_time',
        'online',
        'login_time',
        'pass_req',
        'active',
        'home_phone',
        'present_address',
        'permanent_address',
        'last_edu_achieve',
        'archive',
        'resignation_date',
        'office_stime',
        'office_etime',
        'scheduled_attendance',
        'roster',
        'key',
        'key_date',
        'experience'

    ];


    /**
     * One to one realtionship from `employees` to `departments` table
     * Every employee can assigned with only one department
     * 
     * @author: Akash Chandra Debnath
     */
    public function department()
    {
        return $this->hasOne(Department::class, 'dept_code', 'dept_code');
    }


    /**
     * One to one realtionship from `employees` to `designations` table
     * Every employee can have only one designation
     * 
     * @author: Akash Chandra Debnath
     */
    public function userDesignation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation');
    }


    /**
     * One to one realtionship from `employees` to `grades` table
     * Every employee can have only one grade currently
     * 
     * @author: Akash Chandra Debnath
     */
    public function grade()
    {
        return $this->hasOne(Grade::class, 'id', 'grade_id');
    }


    /**
     * One to one realtionship from `employees` to `status_logs` table
     * Every employee can have only one status currently
     * 
     * @author: Akash Chandra Debnath
     */
    public function status()
    {
        return $this->hasOne(Status_log::class, 'status');
    }


    /**
     * Inverse One to one realtionship from `employees` to `users` table
     * Every employee can have one corresponding user info row which used as login credentials
     * 
     * @author: Akash Chandra Debnath
     */
    public function getUser()
    {
        return $this->belongsTo(User::class, 'username', 'emp_id');
    }


    /**
     * One to many realtionship from `employees` to `attach_msgs` table
     * Every employee can create many attachment message or files
     * 
     * @author: Akash Chandra Debnath
     */
    public function attachment()
    {
        return $this->hasMany(Attach_msg::class, 'message_from', 'emp_id');
    }


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function job_desc()
    {
        return $this->hasOne(Job_desc_files::class, 'emp_id', 'emp_id');
    }


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function leave()
    {
        return $this->hasMany(Leave::class, 'emp_id', 'emp_id');
    }


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function  late_early_req()
    {
        return $this->hasMany(late_early_req::class, 'emp_id', 'emp_id');
    }


    /**
     * One to many realtionship from `employees` to `evaluations` table
     * Every employee can create many evaluation
     * 
     * @author: Akash Chandra Debnath
     */
    public function evaluation()
    {
        return $this->hasMany(Evaluation::class, 'emp_id', 'emp_id');
    }


    /**
     * One to one realtionship from `employees` to `evaluations` table
     * Every employee can have one evaluation at a time
     * 
     * @author: Akash Chandra Debnath
     */
    public function evaluationOne()
    {
        return $this->hasOne(Evaluation::class, 'emp_id', 'emp_id')->orderBy('eve_from', 'desc');
    }


    /**
     * One to one realtionship from `employees` to `weekends` table
     * Every employee can have one weekend value
     * 
     * @author: Akash Chandra Debnath
     */
    public function weekend()
    {
        return $this->hasOne(weekend::class, 'emp_id', 'emp_id');
    }


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function iorecord()
    {
        return $this->hasMany(Iorecords_temp::class, 'emp_id', 'emp_id');
    }
    /**
     * 
     * @author: Tahrim Kabir
     */
    public function iorecordDate()
    {
        $date = date('Y-m-d');
        return $this->hasMany(Iorecords::class, 'emp_id', 'emp_id')->where('date', $date);
    }



    /**
     * 
     * @author: Tahrim Kabir
     */
    public function rostering()
    {
        return $this->hasMany(Rostering::class, 'emp_id', 'emp_id');
    }


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function weekends()
    {
        return $this->hasMany(Weekend::class, 'emp_id', 'emp_id');
    }

   


    /**
     * 
     * @author: Tahrim Kabir
     */
    public function nonSloted()
    {
        return $this->hasMany(EmployeeRosterSchedule::class, 'emp_id', 'emp_id');
    }

    public function nonSlotedByDate()
    {
        $date = date('Y-m-d');
        return $this->hasMany(EmployeeRosterSchedule::class, 'emp_id', 'emp_id')->where('ddate',$date);
    }
}
