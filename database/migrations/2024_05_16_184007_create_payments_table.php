<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('order_id');
            $table->float('amount');
            $table->date('payment_date');
            $table->string('payment_method', 50);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
