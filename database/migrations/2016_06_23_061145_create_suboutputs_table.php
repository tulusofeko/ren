<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuboutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suboutputs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('code', 3)->index();
            $table->string('name');
            $table->timestamps();

            $table->foreign('parent')
                ->references('id')
                ->on('outputs')
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
        Schema::table('suboutputs', function (Blueprint $table) {
            $table->dropForeign('suboutputs_parent_foreign');
        });

        Schema::drop('suboutputs');
    }
}
