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
        Schema::table('lens_purchases', function (Blueprint $table) {
            //
            $table->string('receipt_number')->nullable()->after('vendor_id');
            $table->string('receipt')->nullable()->after('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lens_purchases', function (Blueprint $table) {
            //
            $table->dropColumn('receipt_number');
            $table->dropColumn('receipt');
        });
    }
};
