<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingInfoTable extends Migration
{
    public function up()
    {
        Schema::create('shipping_info', function (Blueprint $table) {
            $table->id('shipping_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->string('address', 255);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('zip_code', 10);
            $table->string('country', 50);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_info');
    }
}

