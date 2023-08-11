<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmsTaskFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ems_task_followups', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->string('emp_id');
            $table->text('description');
            $table->dateTime('date');
            $table->char('status',1);
            $table->dateTime('check_time');
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
        Schema::dropIfExists('ems_task_followups');
    }
}
