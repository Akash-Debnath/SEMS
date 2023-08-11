<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeRosterSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_roster_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('ddate');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('entry_time');
            $table->dateTime('out_time');
            $table->string('dept_code',2);
            $table->text('comment')->nullable();
            $table->char('is_holiday',1);
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
        Schema::dropIfExists('employee_roster_schedules');
    }
}
