<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packagings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('printing');
            $table->boolean('proofreading');
            $table->string('material');
            $table->unsignedInteger('number_of_page');
            $table->string('top_font');
            $table->string('top_color');
            $table->string('top_text');
            $table->string('bottom_font');
            $table->string('bottom_color');
            $table->string('bottom_text');
            $table->string('description')->nullable();
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides');
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
        Schema::dropIfExists('packagings');
    }
}
