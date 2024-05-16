<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id('news_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('title', 100);
            $table->text('content');
            $table->date('post_date');
            $table->timestamps();

            $table->foreign('admin_id')->references('admin_id')->on('admin');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}
