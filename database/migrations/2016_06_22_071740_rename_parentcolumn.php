<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameParentcolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->renameColumn('program', 'parent');
        });

        Schema::table('outputs', function (Blueprint $table) {
            $table->renameColumn('kegiatan', 'parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->renameColumn('parent', 'program');
        });
        
        Schema::table('outputs', function (Blueprint $table) {
            $table->renameColumn('parent', 'kegiatan');
        });
    }
}
