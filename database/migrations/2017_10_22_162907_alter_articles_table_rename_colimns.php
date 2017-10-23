<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticlesTableRenameColimns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('comments_id', 'number_of_comments')->default(0);
            $table->renameColumn('likes_id', 'number_of_likes')->default(0);
            $table->renameColumn('dislikes_id', 'number_of_dislikes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->renameColumn('number_of_comments', 'comemnts_id');
            $table->renameColumn('number_of_likes', 'likes_id');
            $table->renameColumn('number_of_dislikes', 'dislikes_id');
        });
    }
}
