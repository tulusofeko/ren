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
            $table->string('codename', 3);
            $table->string('parent', 2)->nullable();
            $table->string('name');
            $table->integer('pegawai');
            $table->timestamps();

            $table->unique('codename');

            $table->foreign('parent')
                ->references('codename')
                ->on('eselon_satu')
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
        Schema::table('eselon_dua', function (Blueprint $table) {
            $table->dropForeign('eselon_dua_parent_foreign');
        });

        Schema::drop('eselon_dua');
    }
}
