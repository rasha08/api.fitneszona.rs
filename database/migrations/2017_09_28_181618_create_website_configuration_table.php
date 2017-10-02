<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_configuration', function (Blueprint $table) {
            $table->string('home_page');
            $table->string('theme');
            $table->boolean('is_registration_enabled');
            $table->boolean('is_login_enabled');
            $table->string('banner_imgage_url');
            $table->integer('number_of_articles_in_sidebar');
            $table->boolean('is_landing_page_enabled');
            $table->boolean('is_chat_bot_enabled');
            $table->boolean('is_google_map_enabled');
            $table->mediumText('banner_text');
            $table->text('about_us');
            $table->boolean('is_fitness_creator_enabled');
            $table->text('text_for_email_response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_configuratio');
    }
}
