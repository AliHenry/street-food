<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->uuid('user_uuid');
            $table->uuid('role_uuid');

            $table->foreign('user_uuid')->references('user_uuid')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_uuid')->references('role_uuid')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_uuid', 'role_uuid']);

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
        Schema::dropIfExists('user_role');
    }
}
