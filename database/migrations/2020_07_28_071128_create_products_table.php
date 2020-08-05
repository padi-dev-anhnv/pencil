<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->string('name');
            $table->string('color');
            $table->integer('qty');
            $table->string('unit');
            $table->date('shipping_date');
            $table->date('received_date');
            $table->string('body');
            $table->string('direction');
            $table->string('proofreading');
            $table->string('method');
            $table->string('work');
            $table->string('typeface');
            $table->string('font_size')->nullable();
            $table->string('printing_color');
            $table->string('pattern_type');
            $table->string('pattern_text');
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
        Schema::dropIfExists('products');
    }
}
