<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accidents', function (Blueprint $table) {
            $table->increments('id');

            $table->date("accident_date");
            $table->string("accident_time")->nullable();
            $table->date("accident_report_date");
            $table->string("accident_report_time")->nullable();
            $table->text("accident_description")->nullable();
            $table->text("accident_location")->nullable();

            $table->string("witness_1_name")->nullable();
            $table->string("witness_2_name")->nullable();

            $table->string("injury_type"); // WORK RELATED / NON WORK RELATED

            $table->text("management_decision")->nullable();

            $table->string('supervisor')->nullable();

            $table->integer('employee_id')->unsigned();
    			  $table->foreign('employee_id')->references('id')->on('employees');

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
        Schema::drop('accidents');
    }
}
