<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialtyWorkTable extends Migration
{
    public function up()
    {
        Schema::create('specialty_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_id');
            $table->unsignedBigInteger('specialty_id');
            $table->unsignedInteger('percentage')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialty_work');
    }
}
