<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');

            $table->string("company_name");
            $table->text("company_description");
            $table->string("company_logo_name")->nullable();
            $table->text("company_address")->nullable();
            $table->string("company_telephone")->nullable();
            $table->string("company_tin_number")->nullable();
            $table->string("company_ssnit_number")->nullable();
            $table->string("company_email")->nullable();
            $table->string("company_website")->nullable();

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
        Schema::drop('company');
    }
}
