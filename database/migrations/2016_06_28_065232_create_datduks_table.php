<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datduks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned();
            $table->string('filename');
            $table->string('mime_type');
            $table->string('hash');
            $table->timestamps();

            $table->foreign('parent')
                ->references('id')
                ->on('sub_komponens')
                ->onDelete('cascade')
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
        Schema::drop('datduks');
    }
}
