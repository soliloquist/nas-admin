<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->nullable();
            $table->string('article_type')->nullable();
            $table->string('type')->default('p'); // 區塊型式 p|title|image|album
            $table->text('content')->nullable(); // p: html ｜ title: text | image: url
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('enabled');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocks');
    }
}
