<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_loans', function (Blueprint $table) {
            $table->increments('id');

            $table -> string("loan_type"); //COMPANY LOAN | BANK LOAN
            $table -> string("payment_frequency");
            $table -> integer("amount");
            $table -> date("start_date");
            $table -> date("end_date");

            $table -> string("payment_status"); // PAID | PAYING

            $table->integer('bank_id')->unsigned()->nullable();
    			  $table->foreign('bank_id')->references('id')->on('banks');

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
        Schema::drop('staff_loans');
    }
}
