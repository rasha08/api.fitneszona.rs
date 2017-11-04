<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteUsersTableAddColumnFavoriteTags extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('website_users', function (Blueprint $table) {
            $table->string('favorite_tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('website_users', function (Blueprint $table) {
            $table->dropColumn('favorite_tags');
        });
    }
}