<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrmRelevantTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('departments', function(Blueprint $table)
      {
        $table->increments('id');

        $table->string('department_name')->nullable();

        $table->timestamps();
      });

      Schema::create('jobs', function(Blueprint $table)
      {
        $table->increments('id');

        $table->string('job_title');

        $table->integer('department_id')->unsigned();
			  $table->foreign('department_id')->references('id')->on('departments');

        $table->timestamps();
      });

      Schema::create('pay_grades', function(Blueprint $table)
      {
        $table->increments('id');

        $table->text('description');
        $table->string('minimum_salary');
        $table->string('maximum_salary');

        $table->integer('job_id')->unsigned();
			  $table->foreign('job_id')->references('id')->on('jobs');

        $table->timestamps();
      });

      Schema::create('employees', function(Blueprint $table)
      {
        $table->increments('id');

        $table->string('staff_number');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('other_names')->nullable();
        $table->date('date_of_birth');
        $table->string('marital_status');
        $table->string('spouse_name')->nullable();;
        $table->string('gender');
        $table->string('social_security_number');
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
        $table->string('bank_account');
        $table->string('bank_account_number');
        $table->string('picture_name');
        $table->string('qualifications');
        $table->string('date_of_hire');
        $table->string('basic_salary');

        //foreign keys
        $table->integer('job_id')->unsigned();
			  $table->foreign('job_id')->references('id')->on('jobs');

        $table->timestamps();
      });

      Schema::create('dependants', function(Blueprint $table)
      {
        $table->increments('id');

        $table->string('first_name');
        $table->string('last_name');
        $table->string('other_names')->nullable();
        $table->date('date_of_birth');
        $table->string('telephone_number');
        $table->string('gender');

        //foreign keys
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
        Schema::drop('dependants');
        Schema::drop('employees');
        Schema::drop('jobs');
        Schema::drop('departments');
    }
}
