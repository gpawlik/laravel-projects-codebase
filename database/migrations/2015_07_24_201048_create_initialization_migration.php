<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitializationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //Create Roles table
      Schema::create('roles', function(Blueprint $table)
      {
        $table->increments('id');
        $table->string('role_name')->unique();

        $table->timestamps();
      });

      //insert super user data
      DB::table('roles')->insert(
          array(
              'role_name' => 'Super User',
              'created_at' => date('Y-m-d H:i:s', time()),
              'updated_at' => date('Y-m-d H:i:s', time())
            )
      );


      //Create Users table
      Schema::create('users', function(Blueprint $table)
      {
        $table->increments('id');
        $table->string('email')->unique();
        $table->string('username')->unique();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('password', 60);
        $table->integer('status');
        $table->string('image_name')->nullable();

        $table->integer('role_id');
        $table->foreign('role_id')->references('id')->on('roles');

        $table->rememberToken();
        $table->timestamps();
      });

      //insert super user data
      DB::table('users')->insert(
          array(
              'email' => 'super@company.com',
              'username' => 'superuser',
              'first_name' => 'Super',
              'last_name' => 'User',
              'password' => Hash::make("superuser"),
              'status' => 2,
              'image_name' => null,
              'role_id' => '1',
              'created_at' => date('Y-m-d H:i:s', time()),
              'updated_at' => date('Y-m-d H:i:s', time())

          )
      );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('users');
      Schema::drop('roles');
    }
}
