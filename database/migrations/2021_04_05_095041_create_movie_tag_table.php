<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_tag', function (Blueprint $table) {
            $table->unsignedInteger('movie_id');
            $table->unsignedInteger('tag_id');

            $table->primary(['movie_id', 'tag_id']);

            $table->foreign('movie_id')->on('movies')->references('id')
                ->onDelete('cascade');
            $table->foreign('tag_id')->on('tags')->references('id')
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
        Schema::dropIfExists('movie_tag');
    }
}
