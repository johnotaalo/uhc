<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CorrectCountyColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counties', function (Blueprint $table) {
            $table->string('dhis_code')->after('county');
            $table->integer('mfl_code')->after('dhis_code');
            $table->text('coordinates')->after('mfl_code')->nullable();
            $table->string('letter')->after('coordinates');
            $table->dropColumn(['county_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counties', function (Blueprint $table) {
            $table->integer('county_no')->nullable();
            $table->dropColumn(['dhis_code', 'mfl_code', 'coordinates', 'letter']);
        });
    }
}
