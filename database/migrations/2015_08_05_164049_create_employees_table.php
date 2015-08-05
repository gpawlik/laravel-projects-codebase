<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');

            $table->string("first_name");
            $table->string("last_name");
            $table->string("other_names")->nullable();
            $table->date("date_of_birth");
            $table->string("marital_status");
            $table->string("gender");
            $table->string("phone_number");
            $table->string("social_security_number");

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
        Schema::drop('employees');
    }
}
