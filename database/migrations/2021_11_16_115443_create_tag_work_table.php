<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagWorkTable extends Migration
{
    public function up()
    {
        Schema::create('tag_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_work');
    }
}
