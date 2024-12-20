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
        Schema::table('frame_purchases', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('clinic_id')->after('organization_id')->nullable();
            $table->foreign('clinic_id')->nullable()->references('id')->on('clinics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_purchases', function (Blueprint $table) {
            //
            $table->dropForeign('frame_purchases_clinic_id_foreign');
            $table->dropColumn('clinic_id');
        });
    }
};
