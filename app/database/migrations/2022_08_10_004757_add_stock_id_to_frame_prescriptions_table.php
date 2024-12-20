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
        Schema::table('frame_prescriptions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('stock_id')->nullable()->after('prescription_id');
            $table->foreign('stock_id')->nullable()->references('id')->on('frame_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_prescriptions', function (Blueprint $table) {
            //
            $table->dropColumn('stock_id');
        });
    }
};
