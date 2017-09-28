<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('flast_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->mediumText('visited_categories');
            $table->mediumText('visited_tags');
            $table->mediumText('liked_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_users');
    }
}
