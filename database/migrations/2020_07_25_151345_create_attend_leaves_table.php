<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attend_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('calender_id');
            $table->unsignedBigInteger('setting_id');

            $table->unsignedBigInteger('attend_user_status_id');
            $table->time('attend_time', 0)->nullable();
            $table->string('attend_hint', 0)->nullable();//have value if allow attend after time
            $table->time('attend_by_user', 0)->nullable();
            $table->time('attend_by_admin', 0)->nullable();

            $table->unsignedBigInteger('leave_user_status_id');
            $table->time('leave_time', 0)->nullable();
            $table->string('leave_hint', 0)->nullable();//have value if allow leave before time
            $table->time('leave_by_user', 0)->nullable();
            $table->time('leave_by_admin', 0)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('calender_id')->references('id')->on('calenders')->onDelete('cascade');
            $table->foreign('setting_id')->references('id')->on('attend_leave_settings')->onDelete('cascade');
            $table->foreign('attend_user_status_id')->references('id')->on('user_statuses')->onDelete('cascade');
            $table->foreign('leave_user_status_id')->references('id')->on('user_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('attend_leaves');
    }
    
}
