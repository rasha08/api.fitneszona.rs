<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\ArticlesController;

class CreateAllArticlesFbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_articles_fb', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('update');            
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
        Schema::dropIfExists('all_articles_fb');
    }
}
