<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');

            $table->date("leave_start_date");
            $table->date("leave_end_date");

            $table->text("reason_for_leave")->nullable();

            $table->string("saturday_inclusive");
            $table->string("sunday_inclusive");

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
        Schema::drop('leaves');
    }
}
