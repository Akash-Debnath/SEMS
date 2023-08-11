<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->string('leave_type',3)->nullable();
            $table->char('time_slot',2)->nullable();
            $table->date('leave_start')->nullable();
            $table->date('leave_end')->nullable();
            $table->date('m_approved_date')->nullable();
            $table->tinyText('manager_remark')->nullable();
            $table->integer('period')->nullable();
            $table->text('address_d_l')->nullable();
            $table->text('special_reason')->nullable();
            $table->char('comment1',1)->nullable();
            $table->char('comment2',1)->nullable();
            $table->char('comment3',1)->nullable();
            $table->date('admin_approve_date')->nullable();
            $table->tinyText('admin_remark')->nullable();
            $table->char('leave_approval',1)->nullable();
            $table->char('send_to',1)->nullable();
            $table->date('cancel_req_date')->nullable();
            $table->date('cancel_approve_date')->nullable();
            $table->string('manager_id');
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
        Schema::dropIfExists('leaves');
    }
}
