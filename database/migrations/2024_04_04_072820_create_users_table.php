<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id')->change();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email');
            $table->unsignedBigInteger('role_id'); // Using unsignedBigInteger for the foreign key
            $table->foreign('role_id')->references('role_id')->on('role'); // Adding foreign key constraint
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Drop the foreign key constraint
        });
    }
}
