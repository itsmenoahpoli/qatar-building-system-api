<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationProjectDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_project_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->text('type');
            $table->text('name');
            $table->text('no_of_floors');
            $table->longText('others');
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
        Schema::table('application_property_data', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
        });

        Schema::dropIfExists('application_project_data');
    }
}
