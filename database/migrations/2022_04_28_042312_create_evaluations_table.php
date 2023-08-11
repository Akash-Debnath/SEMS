<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('eve_from');
            $table->date('eve_to');
            $table->char('ksa',4)->nullable();
            $table->text('ksa_comments')->nullable();
            $table->char('qlw',4)->nullable();
            $table->text('qlw_comments')->nullable();
            $table->char('qtw',4)->nullable();
            $table->text('qtw_comments')->nullable();
            $table->char('wh',4)->nullable();
            $table->text('wh_comments')->nullable();
            $table->char('com',4)->nullable();
            $table->text('com_comments')->nullable();
            $table->char('dep',4)->nullable();
            $table->text('dep_comments')->nullable();
            $table->char('coo',4)->nullable();
            $table->text('coo_comments')->nullable();
            $table->char('ini',4)->nullable();
            $table->text('ini_comments')->nullable();
            $table->char('ada',4)->nullable();
            $table->text('ada_comments')->nullable();
            $table->char('jud',4)->nullable();
            $table->text('jud_comments')->nullable();
            $table->char('att',4)->nullable();
            $table->text('att_comments')->nullable();
            $table->char('pun',4)->nullable();
            $table->text('pun_comments')->nullable();
            $table->char('led',4)->nullable();
            $table->text('led_comments')->nullable();
            $table->char('del',4)->nullable();
            $table->text('del_comments')->nullable();
            $table->char('pla',4)->nullable();
            $table->text('pla_comments')->nullable();
            $table->char('adm',4)->nullable();
            $table->text('adm_comments')->nullable();
            $table->char('per',4)->nullable();
            $table->text('per_comments')->nullable();
            $table->char('opr',4)->nullable();
            $table->text('opr_comments')->nullable();
            $table->char('hbf',4)->nullable();
            $table->text('hbf_comments')->nullable();
            $table->decimal('avg_rate',3,2)->nullable();
            $table->date('man_sig_date')->nullable();
            $table->string('manager_id')->nullable();
            $table->date('emp_sig_date')->nullable();
            $table->text('emp_comments')->nullable();
            $table->string('emp_attachment')->nullable();
            $table->date('admin_sig_date')->nullable();
            $table->text('admin_comments')->nullable();
            $table->string('admin_id');
            $table->char('status',1)->nullable();
            $table->string('time_in_cur_pos',8)->nullable();
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
        Schema::dropIfExists('evaluations');
    }
}