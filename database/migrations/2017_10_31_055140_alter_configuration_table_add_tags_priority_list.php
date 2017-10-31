<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurationTableAddTagsPriorityList extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_configuration', function (Blueprint $table) {
            $table->string('tags_priority_list')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('website_configuration', function (Blueprint $table) {
            $table->dropColumn('tags_priority_list');
        });
    }
}
