<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherReviewCommentsToApplicationRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_records', function (Blueprint $table) {
            $table->longText('other_review_comments')->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_records', function (Blueprint $table) {
            $table->dropColumn(['other_review_comments']);
        });
    }
}
