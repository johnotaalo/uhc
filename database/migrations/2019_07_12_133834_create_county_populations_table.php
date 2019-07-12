<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountyPopulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('county_populations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('county_id');
            $table->integer('year');
            $table->integer('population');
            $table->integer('rural');
            $table->integer('urban');
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
        Schema::dropIfExists('county_populations');
    }
}
