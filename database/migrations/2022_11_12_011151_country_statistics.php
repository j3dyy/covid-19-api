<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CountryStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_statistics', function (Blueprint $table){

            $table->id();
            $table->bigInteger('country_id')->unsigned();

            $table->integer('confirmed')->default(0);
            $table->integer('recovered')->default(0);
            $table->integer('deaths')->default(0);

            $table->timestamps();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_statistics');
    }
}
