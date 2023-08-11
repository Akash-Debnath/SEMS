<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIorecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iorecords', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->time('stime')->nullable();
            $table->time('etime')->nullable();
            $table->date('date');
            $table->char('system_fault',1)->default("N");
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
        Schema::dropIfExists('iorecords');
    }
}
