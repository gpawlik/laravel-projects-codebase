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
        Schema::create('employee_exits', function (Blueprint $table) {
            $table->increments('id');

            $table->date("date_of_exit");
            $table->text("reason_of_exit"); // TERMINATION | CONTRACT ENDED | RESIGNATION
            $table->text("details_of_exit")->nullable();
            $table->text("resignation_list")->nullable();

            $table->string('staff_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_names')->nullable();
            $table->date('date_of_birth');
            $table->string('marital_status');
            $table->string('spouse_name')->nullable();;
            $table->string('gender');
            $table->string('social_security_number')->nullable();
            $table->string('email');
            $table->string('telephone_number');
            $table->text('mailing_address');
            $table->text('residential_address');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');
            $table->string('next_of_kin');
            $table->string('alergies')->nullable();
            $table->string('fathers_name');
            $table->string('mothers_name');

            $table->integer('bank_id')->unsigned();
    			  $table->foreign('bank_id')->references('id')->on('banks');
            $table->string('bank_account_number');

            $table->string('qualifications');
            $table->date('date_of_hire');

            $table->integer('identification_id')->unsigned();
    			  $table->foreign('identification_id')->references('id')->on('identification');
            $table->string('identification_number');

            //foreign keys
            $table->integer('job_id')->unsigned();
    			  $table->foreign('job_id')->references('id')->on('jobs');

            $table->integer('branch_id')->unsigned();
    			  $table->foreign('branch_id')->references('id')->on('branches');

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
        Schema::drop('employee_exits');
    }
}
