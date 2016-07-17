<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEs3ToSubkom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_komponens', function (Blueprint $table) {
            $table->string('unit_kerja', 4)->nullable()->after('name');

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
            $table->dropColumn('unit_kerja');
        });
    }
}
