<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_locale', function (Blueprint $table) {
            $table->uuid('category_uuid');
            $table->string('lang_iso_code', 10);
            $table->string('name', 150);
            $table->softDeletes();
            $table->primary('category_uuid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_locale');
    }
}
