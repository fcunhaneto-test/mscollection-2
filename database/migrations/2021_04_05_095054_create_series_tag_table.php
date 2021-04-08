<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_tag', function (Blueprint $table) {
            $table->unsignedInteger('series_id');
            $table->unsignedInteger('tag_id');

            $table->primary(['series_id', 'tag_id']);

            $table->foreign('series_id')->on('series')->references('id')
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
        Schema::dropIfExists('series_tag');
    }
}
