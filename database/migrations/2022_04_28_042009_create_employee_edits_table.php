<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_edits', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('last_edu_achieve')->nullable();
            $table->text('experiance')->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group', 3)->nullable();
            $table->char('gender', 1)->nullable();
            $table->char('status', 1);
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
        Schema::dropIfExists('employee_edits');
    }
}
