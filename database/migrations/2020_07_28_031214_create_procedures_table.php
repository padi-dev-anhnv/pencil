<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides');
            $table->string('work');
            $table->string('bagging_content')->nullable();
            $table->string('bagging');
            $table->string('box');
            $table->string('box_content')->nullable();
            $table->string('packaging');
            $table->string('gimmick');
            $table->string('advance_shipment');
            $table->string('material');
            $table->string('note');
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
        Schema::dropIfExists('procedures');
    }
}
