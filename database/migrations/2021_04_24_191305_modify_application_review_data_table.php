<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApplicationReviewDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('application_review_data', function (Blueprint $table) {
        $table->dropColumn(['building_permit_fees']);
        $table->foreignId('user_id')
                  ->after('id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
        $table->text('comments')->nullable()->after('status');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('application_review_data', function (Blueprint $table) {
        $table->dropColumn(['user_id', 'comments']);
      });
    }
}
