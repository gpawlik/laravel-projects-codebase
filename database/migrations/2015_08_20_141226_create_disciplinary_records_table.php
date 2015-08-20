<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplinaryRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinary_records', function (Blueprint $table) {
            $table->increments('id');

            $table->string("type_of_warning"); // VERBAL WARNING | FIRST WARNING LETTER | SECOND WARNING LETTER
            $table->string("action_taken"); // SUSPENSION | DISMISSAL | SUMMARY DISMISSAL
            $table->integer("suspension_number_of_days")->nullable();

            $table->text("offense")->nullable();

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
        Schema::drop('disciplinary_records');
    }
}
