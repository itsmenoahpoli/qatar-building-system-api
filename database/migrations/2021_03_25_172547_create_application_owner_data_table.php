<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationOwnerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_owner_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->text('name');
            $table->text('license_no');
            $table->text('mobile_no');
            $table->text('comments');
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
        Schema::table('application_owner_data', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
        });

        Schema::dropIfExists('application_owner_data');
    }
}
