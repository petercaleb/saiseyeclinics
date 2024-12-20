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
        Schema::table('frame_stocks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('hq_stock_id')->nullable()->after('clinic_id');
            $table->foreign('hq_stock_id')->nullable()->references('id')->on('hq_frame_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_stocks', function (Blueprint $table) {
            //
            $table->dropForeign('frame_stocks_hq_stock_id_foreign');
            $table->dropColumn('hq_stock_id');
        });
    }
};
