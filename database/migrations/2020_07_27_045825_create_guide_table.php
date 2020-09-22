<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('office')->nullable();
            // $table->unsignedInteger('office_id')->nullable();
            // $table->foreign('office_id')->references('id')->on('offices');
            $table->string('number')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('store_code')->nullable();
            $table->boolean('last_exist')->nullable();
            $table->date('last_date')->nullable();
            $table->string('last_numb')->nullable();
            $table->string('customer_name')->nullable();  
            $table->string('curator')->nullable();  
            $table->text('price')->nullable();
            $table->text('products')->nullable();
            $table->string('key_code')->nullable();
            $table->boolean('export')->nullable()->default(false);
            $table->string('old_creator')->nullable();
            $table->date('shipping_date')->nullable(); 
            $table->date('received_date')->nullable(); 
            // $table->unsignedInteger('clone_id')->nullable();
            // $table->foreign('clone_id')->references('id')->on('users');
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
        Schema::dropIfExists('guides');
    }
}
