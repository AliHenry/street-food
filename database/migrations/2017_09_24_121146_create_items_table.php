<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->uuid('item_uuid');
            $table->uuid('biz_uuid');
            $table->uuid('category_uuid');
            $table->double('price')->default(0.0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('item');
    }
}
