<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_statistic', function (Blueprint $table) {
            $table->integer('user_id')->unique()->foreign('user_id')->references('id')->on('website_users')->onDelete('cascade');
            $table->mediumText('visited_tags')->nullable();
            $table->mediumText('visited_categories')->nullable();
            $table->mediumText('last_visit_and_page')->nullable();
            $table->mediumText('number_of_visits')->nullable();
            $table->mediumText('number_of_visits_by_day')->nullable();
            $table->mediumText('liked_texts')->nullable();
            $table->mediumText('disliked_texts')->nullable();
            $table->mediumText('commented_texts')->nullable();
            $table->mediumText('texts_open_from_left_sidebar')->nullable();
            $table->mediumText('texts_open_from_right_sidebar')->nullable();
            $table->mediumText('texts_open_that_was_featured')->nullable();
            $table->mediumText('texts_open_from_index_page')->nullable();
            $table->mediumText('texts_open_from_all_articles_page')->nullable();
            $table->mediumText('texts_open_from_top_articles_page')->nullable();
            $table->mediumText('texts_open_from_latest_articles_page')->nullable();
            $table->mediumText('time_of_visits')->nullable();
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
        Schema::dropIfExists('users_statistic');
    }
}
