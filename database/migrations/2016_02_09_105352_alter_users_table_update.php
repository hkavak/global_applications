<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table){
            $table->dropColumn('name');
            $table->string('first_name', 50)->after('id');
            $table->string('last_name', 50)->after('first_name');
            $table->string('ssn',50)->after('last_name')->unique();
            $table->string('role_id',50)->after('email');
            $table->string('username',50)->after('role_id')->unique(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table){
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
            $table->dropColumn('ssn');
            $table->dropColumn('role_id');
            $table->dropColumn('username');
            $table->string('name')->after('id');
        });
    }
}
