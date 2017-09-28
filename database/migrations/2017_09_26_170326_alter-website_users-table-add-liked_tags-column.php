<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteUsersTableAddLikedTagsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_users', function (Blueprint $table) {
            $table->mediumText('liked_tags')->nullable()->after('liked_categories');
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
            $table->dropColumn('liked_tags');
        });
    }
}
