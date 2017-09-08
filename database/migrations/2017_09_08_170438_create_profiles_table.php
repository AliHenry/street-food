<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('profile_uuid');
            $table->uuid('user_uuid');
            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->date('dob');
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();

            $table->primary('profile_uuid');

            $table->foreign('user_uuid')
                ->references('user_uuid')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}