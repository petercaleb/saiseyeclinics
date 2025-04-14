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
            $table->unsignedBigInteger('case_stock_id')->nullable()->after('stock_id');
            $table->string('case_code')->nullable()->after('frame_code');
            $table->foreign('case_stock_id')->nullable()->references('id')->on('case_stocks')->onDelete('set null');
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
            $table->dropColumn('case_stock_id');
            $table->dropColumn('case_code');
        });
    }
};
