<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripePaymentApplicationRecordPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('application_record_payments', function (Blueprint $table) {
        $table->foreignId('payment_record_id')
              ->adter('id')
              ->nullable()
              ->constrained('payment_records')
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
      Schema::table('application_record_payments', function (Blueprint $table) {
        $table->dropColumn(['payment_record_id']);
      });
    }
}
