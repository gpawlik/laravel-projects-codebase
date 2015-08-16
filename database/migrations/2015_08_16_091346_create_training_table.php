<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('training', function (Blueprint $table) {
          $table->increments('id');

          $table->string("training_type"); //INTERNAL / EXTERNAL
          $table->integer("training_total_cost");
          $table->text("traning_cost_components");
          $table->string("training_start_date");
          $table->string("training_end_date");

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
        Schema::drop('training');
    }
}
