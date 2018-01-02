<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TextsOpenFromCategoryPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_statistic', function (Blueprint $table) {
            $table->string('texts_open_from_category_page')->after('texts_open_from_latest_articles_page')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('users_statistic', function (Blueprint $table) {
            $table->dropColumn('texts_open_from_category_page');
        });
    }
}
