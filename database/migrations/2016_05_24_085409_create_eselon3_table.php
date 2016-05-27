<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEselon3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eselon_tiga', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codename',  4);
            $table->string('eselondua', 3);
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
        Schema::drop('eselon_tiga');
    }
}
