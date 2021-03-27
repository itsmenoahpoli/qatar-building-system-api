<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPropertyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_property_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->string('pin_no', 50);
            $table->text('municipality');
            $table->text('location');
            $table->text('street_no');
            $table->text('street_name');
            $table->text('real_estate_no');
            $table->text('land_no');
            $table->text('title_deed');
            $table->text('area_space');
            $table->text('total_build_up_area');

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
        // Schema::table('application_property_data', function (Blueprint $table) {
        //     $table->dropForeign(['application_record_id']);
        // });

        Schema::dropIfExists('application_property_data');
    }
}
