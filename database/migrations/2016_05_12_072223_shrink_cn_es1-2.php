<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShrinkCnEs12 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eselon_dua', function ($table) {
            $table->string('codename', 3)->change();
            $table->string('eselonsatu', 2)->change();
        });        

        Schema::table('eselon_satu', function ($table) {
            $table->string('codename', 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eselon_dua', function ($table) {
            $table->string('codename', 4)->change();
            $table->string('eselonsatu', 3)->change();
        });        

        Schema::table('eselon_satu', function ($table) {
            $table->string('codename', 16)->change();
        });
    }
}
