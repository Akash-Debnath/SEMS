<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraWorkReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_work_reports', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('apply_date');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->text('work_details')->nullable();
            $table->char('work_assigned_by',50);
            $table->char('work_priority',1)->nullable();
            $table->integer('request_time');
            $table->text('remarks');
            $table->char('is_verified',1);
            $table->integer('verify_time');
            $table->char('verified_by');
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
        Schema::dropIfExists('extra_work_reports');
    }
}