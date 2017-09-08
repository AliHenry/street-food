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
            $table->uuid('user_uuid');
            $table->uuid('role_uuid');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('varifid');
            $table->string('varified_token');
            $table->rememberToken();
            $table->timestamps();

            $table->primary('user_uuid');


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
