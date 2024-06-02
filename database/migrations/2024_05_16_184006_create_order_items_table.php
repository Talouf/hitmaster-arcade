<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->string('user_id'); // Changed to string to accommodate session IDs
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->boolean('is_ordered')->default(false);
    $table->integer('quantity')->default(1);
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
}

public function down()
{
    Schema::dropIfExists('order_items');
}
}