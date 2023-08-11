<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissingAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missing_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('date');
            $table->time('in')->nullable();
            $table->time('out')->nullable();
            $table->text('reason');
            $table->char('status',1);
            $table->date('m_approved_date')->nullable();
            $table->date('a_verified_date')->nullable();
            $table->string('manager_id',191)->nullable();
            $table->string('admin_id',191)->nullable();
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
        Schema::dropIfExists('missing_attendances');
    }
}
