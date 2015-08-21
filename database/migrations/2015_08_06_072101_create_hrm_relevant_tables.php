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
        $table->integer('job_capacity')->nullable();

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

      Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');

            $table->string("branch_name");
            $table->string("branch_location")->nullable();

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

        $table->string('picture_name')->nullable();
        $table->string('qualifications');
        $table->date('date_of_hire');

        $table->double('basic_salary')->nullable();
        $table->double("employee_welfare_contribution")->nullable();
        $table->double("allowances")->nullable();

        $table->double('net_salary')->nullable();
        $table->string('tax_identification_number')->nullable();
        $table->string('number_of_dependants')->nullable();

        $table->string('employment_status'); // ACTIVE | TERMINATED

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
        Schema::drop('employees');
        Schema::drop('branches');
        Schema::drop('pay_grades');
        Schema::drop('jobs');
        Schema::drop('departments');
    }
}
