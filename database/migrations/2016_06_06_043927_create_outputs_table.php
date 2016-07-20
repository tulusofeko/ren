<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent', 4);
            $table->string('code', 3);
            $table->string('name');
            $table->timestamps();

            $table->foreign('parent')
                ->references('code')
                ->on('kegiatans')
                ->onDelete('restrict')
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
        Schema::table('outputs', function (Blueprint $table) {
            $table->dropForeign('outputs_parent_foreign');
        });

        Schema::drop('outputs');
    }
}
