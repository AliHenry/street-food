<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->uuid('biz_uuid');
            $table->uuid('user_uuid');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('logo');
            $table->string('address');
            $table->string('street');
            $table->string('city', 50)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip', 12)->nullable();
            $table->string('phone', 30)->nullable();
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->timestamps();

            $table->primary('biz_uuid');

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
        Schema::dropIfExists('business');
    }
}
