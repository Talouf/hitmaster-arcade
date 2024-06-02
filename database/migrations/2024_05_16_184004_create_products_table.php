<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('details')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->foreignId('category_id')->default(1)->constrained('categories')->onDelete('cascade'); // Default to category ID 1
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}




