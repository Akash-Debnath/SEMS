<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->bigIncrements('option_id');
            $table->string('option_name');
            $table->string('option_code');
            $table->string('option_value');
            $table->integer('leave_m')->nullable();
            $table->integer('leave_f')->nullable();
            $table->string('roster_dept')->nullable();
            $table->time('stime')->nullable();
            $table->time('etime')->nullable();
            $table->integer('leave_days')->nullable();
            $table->char('prescription')->default('N');
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
        //
    }
}
