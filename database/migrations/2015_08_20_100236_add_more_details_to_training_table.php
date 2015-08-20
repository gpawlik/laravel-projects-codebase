<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreDetailsToTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training', function (Blueprint $table) {

            $table->string('training_facilitator')->nullable();
            $table->string('training_topic')->nullable();
            $table->string('training_location')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training', function (Blueprint $table) {
            $table->dropColumn("training_location");
            $table->dropColumn("training_topic");
            $table->dropColumn("training_facilitator");
        });
    }
}
