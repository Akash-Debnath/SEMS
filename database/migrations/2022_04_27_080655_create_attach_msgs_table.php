<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_msgs', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->date('message_date')->nullable();
            $table->text('read_by')->nullable();
            $table->string('message_from')->nullable();
            $table->string('message_to')->nullable();
            $table->text('custom_recipient')->nullable();
            $table->char('is_encrypted',1);
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
        Schema::dropIfExists('attach_msgs');
    }
}
