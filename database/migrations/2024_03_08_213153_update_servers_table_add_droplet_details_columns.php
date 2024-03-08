<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServersTableAddDropletDetailsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->string('droplet_name')->after('droplet_id');
            $table->string('droplet_size')->after('droplet_id');
            $table->string('droplet_region')->after('droplet_id');
            $table->string('droplet_image')->after('droplet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('droplet_name');
            $table->dropColumn('droplet_size');
            $table->dropColumn('droplet_region');
            $table->dropColumn('droplet_image');
        });
    }
}
