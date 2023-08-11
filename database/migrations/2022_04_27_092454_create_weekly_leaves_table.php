<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->char('sat',1)->default("Y");
            $table->char('sun',1)->default("N");
            $table->char('mon',1)->default("N");
            $table->char('tue',1)->default("N");
            $table->char('wed',1)->default("N");
            $table->char('thu',1)->default("N");
            $table->char('fri',1)->default("Y");
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
        Schema::dropIfExists('weekly_leaves');
    }
}
