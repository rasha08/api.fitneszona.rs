<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWebsiteConfigurationTableRemameColumnBannerImgageToBannerImage extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_configuration', function (Blueprint $table) {
            $table->renameColumn('banner_imgage_url', 'banner_image_url');
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
            $table->renameColumn('banner_image_url', 'banner_imgage_url');
        });
    }
}
