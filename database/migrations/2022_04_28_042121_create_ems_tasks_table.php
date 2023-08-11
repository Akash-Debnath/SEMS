<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmsTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ems_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('dept_code',2);
            $table->string('subject');
            $table->text('description');
            $table->dateTime('date_time');
            $table->char('status');
            $table->string('assigned_by');
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
        Schema::dropIfExists('ems_tasks');
    }
}
