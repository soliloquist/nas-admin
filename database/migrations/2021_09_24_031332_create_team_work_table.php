<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamWorkTable extends Migration
{
    public function up()
    {
        Schema::create('team_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('work_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_work');
    }
}
