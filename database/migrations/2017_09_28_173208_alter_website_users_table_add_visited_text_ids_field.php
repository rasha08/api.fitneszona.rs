<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteUsersTableAddVisitedTextIdsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_users', function (Blueprint $table) {
            $table->text('visited_text_id')->after('liked_tags');
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
            $table->dropColumn('visited_text_id');
        });
    }
}
