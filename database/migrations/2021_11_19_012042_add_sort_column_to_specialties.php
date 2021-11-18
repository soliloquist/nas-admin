<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortColumnToSpecialties extends Migration
{
    public function up()
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->unsignedInteger('sort');
        });
    }

    public function down()
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
}
