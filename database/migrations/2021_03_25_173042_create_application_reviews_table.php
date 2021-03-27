<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->text('engineer_category');
            $table->text('engineer_id');
            $table->text('building_permit_fees');
            $table->text('status');
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
        Schema::table('application_reviews', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
        });

        Schema::dropIfExists('application_reviews');
    }
}
