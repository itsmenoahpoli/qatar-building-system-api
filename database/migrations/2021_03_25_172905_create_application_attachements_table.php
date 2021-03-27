<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationAttachementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_attachements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_record_id')
                  ->constrained('application_records');
            $table->text('attachement_type');
            $table->text('file_path');
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
        Schema::table('application_attachements', function (Blueprint $table) {
            $table->dropForeign(['application_record_id']);
        });

        Schema::dropIfExists('application_attachements');
    }
}
