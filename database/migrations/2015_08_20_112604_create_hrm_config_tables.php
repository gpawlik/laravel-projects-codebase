<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrmConfigTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_config', function (Blueprint $table) {
            $table->increments('id');

            $table->double("ssnit_percentage");
            $table->integer("employer_welfare_contribution");
            $table->integer("employee_leave_entitlement");

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
        Schema::drop('hrm_config');
    }
}
