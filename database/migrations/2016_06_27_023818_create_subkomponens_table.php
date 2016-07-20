<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubkomponensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_komponens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('code', 3)->index();
            $table->string('name');
            $table->string('unit_kerja', 4)->nullable();

            $table->string('anggaran');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('parent')
                ->references('id')
                ->on('komponens')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('unit_kerja')
                ->references('codename')
                ->on('eselon_tiga')
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
        Schema::table('sub_komponens', function (Blueprint $table) {
            $table->dropForeign('sub_komponens_parent_foreign');
            $table->dropForeign('sub_komponens_unit_kerja_foreign');
        });
        
        Schema::drop('sub_komponens');
    }
}
