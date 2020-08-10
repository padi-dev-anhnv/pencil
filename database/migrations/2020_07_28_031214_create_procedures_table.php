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
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->string('work')->nullable();
            $table->string('bagging_content')->nullable();
            $table->string('bagging')->nullable();
            $table->string('box')->nullable();
            $table->string('box_content')->nullable();
            $table->string('packaging')->nullable();
            $table->string('gimmick')->nullable();
            $table->string('advance_shipment')->nullable();
            $table->string('material')->nullable();
            $table->string('note')->nullable();
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
