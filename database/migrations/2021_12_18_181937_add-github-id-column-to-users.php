<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGithubIdColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add github id to users table for github login
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable();
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
            $table->dropColumn('github_id');
        });
    }
}
