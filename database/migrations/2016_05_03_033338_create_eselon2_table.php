<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEselon2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eselon_dua', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codename', 16);
            $table->string('eselonsatu', 16);
            $table->string('name');
            $table->timestamps();
            $table->unique('codename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('eselon_dua');
    }
}
