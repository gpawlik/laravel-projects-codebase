<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');

            $table->string("applicant_first_name");
            $table->string("applicant_last_name");
            $table->string("applicant_email");
            $table->string("applicant_contact_number");
            $table->string("application_status"); // PENDING | ACCEPTED
            $table->date("application_date");
            $table->date("applicant_interview_date")->nullable();

            $table->string("applicant_cv_file_name")->nullable();
            $table->string("applicant_letter_file_name")->nullable();

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
        Schema::drop('applications');
    }
}
