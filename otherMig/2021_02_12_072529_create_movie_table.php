<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->id('movie_id');
            // $table->integer('category_id')->unsigned();        
            // $table->foreign('category_id')->references('category_id')->on('category');
            $table->foreignId('category_id')->constrained();
            $table->string('movie_name');
            $table->string('release_date');
            $table->string('description')->nullable();
            $table->text('img_url');
            $table->integer('quantity_stock');
            $table->integer('price');
            $table->boolean('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie');
    }
}
