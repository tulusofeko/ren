<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eselon_dua', function ($table) {
            $table->renameColumn('eselonsatu', 'parent')->change();
        });        

        Schema::table('eselon_tiga', function ($table) {
            $table->renameColumn('eselondua', 'parent')->change();
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
            $table->renameColumn('parent', 'eselonsatu')->change();
        });        

        Schema::table('eselon_tiga', function ($table) {
            $table->renameColumn('parent', 'eselondua')->change();
        });
    }
}
