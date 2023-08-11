<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLateEarlyReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('late_early_reqs', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('date');
            $table->char('late_req',1)->nullable();
            $table->char('early_req',1)->nullable();
            $table->char('absent_req',1)->nullable();
            $table->char('special_req',1)->nullable();
            $table->text('reason');
            $table->char('approved',1)->default('N');
            $table->dateTime('approved_time')->nullable();
            $table->string('approved_by')->nullable();
            $table->char('verified',1)->default('N');
            $table->dateTime('verified_time')->nullable();
            $table->string('verified_by')->nullable();
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
        Schema::dropIfExists('late_early_reqs');
    }
}
