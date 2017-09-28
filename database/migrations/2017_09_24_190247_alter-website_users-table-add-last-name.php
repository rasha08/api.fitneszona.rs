<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteUsersTableAddLastName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_users', function (Blueprint $table) {
            $table->renameColumn('flast_name', 'last_name');
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
            $table->renameColumn('last_name', 'flast_name');
        });
    }
}
