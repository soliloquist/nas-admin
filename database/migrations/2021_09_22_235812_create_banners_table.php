<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->string('position')->default('index'); // 顯示之頁面  index|vision
            $table->string('type')->default('image'); // image/video
            $table->string('video_host')->nullable(); // video 來源平台: youtube|vimeo ...
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_id')->nullable(); // 對應 video 平台的影片id
            $table->string('link')->nullable();
            $table->boolean('display')->default(0); // 設為顯示，如果有上多個圖，一次只會有一個圖為顯示
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
