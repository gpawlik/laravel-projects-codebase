<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->string("permission_name");

            $table -> integer('role_id')->unsigned();
			      $table -> foreign('role_id')->references('id')->on('roles');

            $table->timestamps();
        });

        //insert super user data
        DB::table('permissions')->insert(
            array(
                'permission_name' => 'system_role_can_permit',
                'role_id' => '1',
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())
              )
        );

        //insert super user data
        DB::table('permissions')->insert(
            array(
                'permission_name' => 'system_role_can_view',
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
        Schema::drop('permissions');
    }
}
