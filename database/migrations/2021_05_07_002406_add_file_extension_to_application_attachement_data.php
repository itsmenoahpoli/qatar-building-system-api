<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileExtensionToApplicationAttachementData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_attachement_data', function (Blueprint $table) {
            $table->string('file_extension', 100)->nullable()->after('file_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_attachement_data', function (Blueprint $table) {
            $table->dropColumn(['file_extension']);
        });
    }
}
