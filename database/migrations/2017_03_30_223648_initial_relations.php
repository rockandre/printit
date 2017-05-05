<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departaments');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('parent_id')->references('id')->on('comments');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('printer_id')->references('id')->on('printers');
            $table->foreign('closed_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['printer_id']);
            $table->dropForeign(['closed_user_id']);
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
    }
}
