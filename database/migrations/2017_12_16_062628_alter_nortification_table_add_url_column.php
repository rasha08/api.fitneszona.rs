<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNortificationTableAddUrlColumn extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nortifications', function (Blueprint $table) {
            $table->string('url')->after('notification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('nortifications', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
}
