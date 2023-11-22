<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetAssetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_asset_groups', function (Blueprint $table) {
            // $table->integer('asset_id');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            // $table->integer('asset_group_id');
            $table->foreignId('asset_group_id')->constrained('asset_groups')->onDelete('cascade');;

            $table->unique(['asset_id', 'asset_group_id'], 'asset_asset_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_asset_groups');
    }
}
