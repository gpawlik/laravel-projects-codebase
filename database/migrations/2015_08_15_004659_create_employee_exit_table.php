<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeExitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('terminations', function (Blueprint $table) {
          $table->increments('id');

          $table->date("date_of_termination");
          $table->text("reason_for_termination"); // TERMINATION | CONTRACT ENDED | RESIGNATION
          $table->text("details_of_termination")->nullable();
          $table->text("resignation_list")->nullable();

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
        Schema::drop('terminations');
    }
}
