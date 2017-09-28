<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteUsersTableAddNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_users', function (Blueprint $table) {
            $table->mediumText('visited_categories')->nullable()->change();
            $table->mediumText('visited_tags')->nullable()->change();
            $table->mediumText('liked_categories')->nullable()->change();
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
            $table->mediumText('visited_categories')->change();
            $table->mediumText('visited_tags')->change();
            $table->mediumText('liked_categories')->change();
        });
    }
}
