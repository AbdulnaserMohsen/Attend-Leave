<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendLeaveSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attend_leave_settings', function (Blueprint $table) {
            $table->id();
            $table->time('attend_time_from', 0);
            $table->time('attend_time_to', 0);
            $table->smallInteger('enable_after_attend')->default(0);
            $table->time('leave_time_from', 0);
            $table->time('leave_time_to', 0);
            $table->smallInteger('enable_before_leave')->default(0);
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
        Schema::dropIfExists('attend_leave_settings');
    }
}
