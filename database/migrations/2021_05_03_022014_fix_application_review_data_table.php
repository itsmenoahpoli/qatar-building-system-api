<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixApplicationReviewDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('application_review_data', function (Blueprint $table) {
        
        $table->id();
        $table->foreignId('application_record_id')
                  ->constrained('application_records');
        $table->foreignId('user_id')
                  ->constrained('users');
        $table->integer('engineer_category');
        $table->string('engineer_category_name', 100);
        $table->string('status', 100);
        $table->string('comments', 100)->nullable();
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
      // Schema::drop('application_review_data');
    }
}
