<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agriculture_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('lowest_price',10,2);
            $table->decimal('highest_price',10,2);
            $table->timestamps();

            $table->foreign('agriculture_id')->references('id')->on('agricultures')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standard_prices');
    }
}
