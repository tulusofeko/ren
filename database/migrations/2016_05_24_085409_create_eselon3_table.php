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
            $table->string('parent', 3)->nullable();
            $table->string('name');
            $table->integer('pegawai');
            $table->timestamps();

            $table->unique('codename');

            $table->foreign('parent')
                ->references('codename')
                ->on('eselon_dua')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eselon_tiga', function (Blueprint $table) {
            $table->dropForeign('eselon_tiga_parent_foreign');
        });

        Schema::drop('eselon_tiga');
    }
}
