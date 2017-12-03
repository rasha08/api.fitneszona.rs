<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_users_configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->foreign('user_id')->references('id')->on('website_users')->onDelete('cascade');
            $table->string('thema')->nullable();
            $table->mediumText('categories_in_navigation')->nullable();
            $table->integer('number_of_texts_in_left_sidebar')->nullable();
            $table->mediumText('noritification_for_themes')->nullable();
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
        Schema::dropIfExists('website_users_configuration');
    }
}