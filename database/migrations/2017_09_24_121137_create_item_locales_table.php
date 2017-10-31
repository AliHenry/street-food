<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_locale', function (Blueprint $table) {
            $table->uuid('item_uuid');
            $table->string('lang_iso_code', 10);
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('item_uuid');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_locale');
    }
}
