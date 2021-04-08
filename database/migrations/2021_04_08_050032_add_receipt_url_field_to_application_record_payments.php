<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiptUrlFieldToApplicationRecordPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_record_payments', function (Blueprint $table) {
            $table->text('stripe_receipt_url')->nullable()->after('amount');
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
            $table->dropColumn(['stripe_receipt_url']);
        });
    }
}
