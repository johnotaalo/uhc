<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeValuesNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->text('organization_description')->nullable()->change();
        });

        Schema::table('data_fields', function (Blueprint $table) {
            $table->text('data_description')->nullable()->change();
            $table->text('data_code')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->text('organization_description')->change();
        });

        Schema::table('data_fields', function (Blueprint $table) {
            $table->text('data_description')->nullable()->change();
            $table->text('data_code')->change();
        });
    }
}
