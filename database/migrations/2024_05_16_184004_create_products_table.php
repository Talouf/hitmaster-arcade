<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('name', 100);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->float('price');
            $table->text('description')->nullable();
            $table->integer('stock_quantity');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
