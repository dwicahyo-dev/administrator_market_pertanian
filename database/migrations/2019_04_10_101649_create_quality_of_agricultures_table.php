<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualityOfAgriculturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_of_agricultures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agriculture_id')->unsigned();
            $table->integer('quality_id')->unsigned();
            $table->timestamps();

            $table->foreign('agriculture_id')->references('id')->on('agricultures')->onDelete('cascade');
            $table->foreign('quality_id')->references('id')->on('qualities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_of_agricultures');
    }
}
