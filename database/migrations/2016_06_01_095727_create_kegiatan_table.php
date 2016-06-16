<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 4)->unique();
            $table->string('eselondua', 3)->nullable();
            $table->string('program', 2)->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('eselondua')
                ->references('codename')
                ->on('eselon_dua')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('program')
                ->references('code')
                ->on('programs')
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
        Schema::drop('kegiatans');
    }
}
