<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',2); // zh|en|jp
            $table->string('label'); // 顯示於介面上的文字（如果有需要）
        });
    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
