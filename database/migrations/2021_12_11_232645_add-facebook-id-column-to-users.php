<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacebookIdColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add facebook id to users table for facebook login
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop column when rolling back migration
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('facebook_id');
        });
    }
}
