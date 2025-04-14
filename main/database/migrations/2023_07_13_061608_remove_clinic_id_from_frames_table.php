<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frames', function (Blueprint $table) {
            //
            $table->dropForeign('frames_clinic_id_foreign');
            $table->dropColumn('clinic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frames', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('clinic_id')->after('id')->nullable();
            $table->foreign('clinic_id')->nullable()->references('id')->on('clinics')->onDelete('cascade');
        });
    }
};
