<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserArticlesFirebaseTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_articles_fb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');            
            $table->longText('top');
            $table->longText('latest');
            $table->longText('index');                                                                                     
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
        Schema::dropIfExists('user_articles_fb');
    }
}
