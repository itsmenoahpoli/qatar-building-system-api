<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationRecordIdToPaymentRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_records', function (Blueprint $table) {
          $table->foreignId('application_record_id')
          ->after('id')
          ->nullable()
          ->constrained('application_records')
          ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_records', function (Blueprint $table) {
            $table->dropColumn(['application_record_id']);
        });
    }
}
