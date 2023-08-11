<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRosteringTmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rostering_tmps', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->dateTime('stime')->nullable();
            $table->dateTime('etime')->nullable();
            $table->char('is_incharge',1)->nullable();
            $table->timestamp('tstamp');
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
        Schema::dropIfExists('rostering_tmps');
    }
}
