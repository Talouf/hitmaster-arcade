<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->date('order_date');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // Add status for tracking the order state
            $table->string('email')->nullable();
            $table->timestamps(); // Adding email column for guest orders
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}




