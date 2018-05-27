<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('user_type')->default(0); //0-Employee, 1-Admin, 2-HR
            $table->integer('status')->default(0); //1-Active, 0-
            $table->integer('photo_id')->unsigned()->index()->nullable();
            $table->string('education')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('birth_date')->nullable();
            $table->boolean('gender')->default(1);
            $table->string('mobile')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('campus')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
