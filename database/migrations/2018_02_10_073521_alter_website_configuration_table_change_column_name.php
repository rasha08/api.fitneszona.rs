<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteConfigurationTableChangeColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_configuration', function (Blueprint $table) {
            $table->renameColumn('is_google_map_enabled', 'is_promo_banner_enabled');
            $table->string('banner_title');
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
            $table->renameColumn('is_promo_banner_enabled', 'is_google_map_enabled');
            $table->dropColumn('banner_title');
        });
    }
}
