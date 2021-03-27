<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationOthersDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_others_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->text('quote_no');
            $table->text('client_no');
            $table->text('client_name');
            $table->longText('required_works');
            $table->longText('others');
            $table->longText('services_fees');
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
        Schema::table('application_others_data', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
        });

        Schema::dropIfExists('application_others_data');
    }
}
