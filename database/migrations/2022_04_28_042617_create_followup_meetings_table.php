<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followup_meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id');
            $table->string('subject');
            $table->text('description');
            $table->dateTime('meeting_date');
            $table->dateTime('announce_at');
            $table->text('meeting_update')->nullable();
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
        Schema::dropIfExists('followup_meetings');
    }
}
