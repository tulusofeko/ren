<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahJumlahPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eselon_dua', function (Blueprint $table) {
            $table->integer('pegawai')->after('name');
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
            $table->dropColumn('pegawai');
        });
    }
}
