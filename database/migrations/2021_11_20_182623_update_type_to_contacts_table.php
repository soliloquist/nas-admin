<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTypeToContactsTable extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('contact_type_id');
            $table->string('type');
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_type_id');
            $table->dropColumn('type');
        });
    }
}
