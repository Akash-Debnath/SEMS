<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRosteringControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rostering_controls', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tstamp');
            $table->char('dept_code',2)->index();
            $table->string('emp_id')->index();
            $table->date('sdate')->index();
            $table->date('edate')->index();
            $table->text('reason');
            $table->string('sender_id');
            $table->string('admin_id');
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
        Schema::dropIfExists('rostering_controls');
    }
}
