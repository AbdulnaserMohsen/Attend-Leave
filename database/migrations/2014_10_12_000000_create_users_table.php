<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name_ar');
            $table->string('name_en');
            $table->unsignedBigInteger('job_id');
            $table->string('user_name')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->mediumInteger('type')->default(0); //0 user 1 monitor 2 admin 3 superadmin
            $table->mediumInteger('reset_pass')->default(0); //0  no  1 yes
            $table->mediumInteger('disable_account')->default(0); //0  no  1 yes

            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
