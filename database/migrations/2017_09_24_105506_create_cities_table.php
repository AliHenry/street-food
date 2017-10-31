<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->uuid('city_uuid');
            $table->string('country_code', 100);
            $table->string('short_name', 100);
            $table->string('long_name', 100);
            $table->string('type', 100)->nullable();
            $table->timestamps();

            $table->primary('city_uuid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city');
    }
}
