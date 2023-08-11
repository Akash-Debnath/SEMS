<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->index();
            $table->string('name')->index();
            $table->string('dept_code',2);
            $table->integer('designation');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('jdate');
            $table->date('dob')->nullable();
            $table->char('gender',1);
            $table->char('status',1);
            $table->char('grade_id')->nullable();
            $table->string('blood_group',100)->nullable();
            $table->string('image')->nullable();
            $table->string('pass');
            $table->text('cur_status')->nullable();
            $table->dateTime('status_time')->nullable();
            $table->char('online',1)->nullable();
            $table->dateTime('login_time')->nullable();
            $table->char('pass_req',1)->nullable();
            $table->char('active',1)->nullable();
            $table->string('home_phone',15)->nullable();
            $table->string('present_address',250)->nullable();
            $table->string('permanent_address',250)->nullable();
            $table->string('last_edu_achieve',250)->nullable();
            $table->char('archive',1)->nullable();
            $table->dateTime('resignation_date')->nullable();
            $table->time('office_stime')->nullable();
            $table->time('office_etime')->nullable();
            $table->char('scheduled_attendance',1)->nullable();
            $table->char('roster',1)->nullable();
            $table->string('key',32)->nullable();
            $table->timestamp('key_date');
            $table->text('experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}