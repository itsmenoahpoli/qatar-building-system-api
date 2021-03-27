<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationApplicantDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_applicant_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->foreignId('user_id')
                  ->constrained('users');
            $table->text('type_of_applicant');
            $table->text('name');
            $table->text('license_no');
            $table->text('mobile_no');
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
        Schema::table('application_applicant_data', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('application_applicant_data');
    }
}
