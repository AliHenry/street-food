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
            $table->string('logo')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('address')->nullable();
            $table->uuid('country_uuid')->nullable();
            $table->uuid('city_uuid')->nullable();
            $table->uuid('district_uuid')->nullable();
            $table->string('phone', 30)->nullable();
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->timestamps();

            $table->primary('biz_uuid');

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
