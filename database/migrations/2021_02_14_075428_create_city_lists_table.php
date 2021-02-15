<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_lists', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('country');
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
        Schema::dropIfExists('city_lists');
    }
}
