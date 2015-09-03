<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 64)->unique();
            $table->string('password', 64);
            $table->string('email', 64)->unique();
            $table->integer('last_login_time', 0, true)->nullable();
            $table->integer('last_logout_time', 0, true)->nullable();
            $table->string('last_login_ip', 16)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_admin')->default(0);
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
        Schema::drop('user');
    }
}
