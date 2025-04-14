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
        Schema::table('payment_bills', function (Blueprint $table) {
            // Drop column claimed amount
            $table->dropColumn('claimed_amount');

            //Add column frame_amount and lens amount
            $table->decimal('frame_amount', 10, 2)->nullable();
            $table->decimal('lens_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_bills', function (Blueprint $table) {
            
            // Add column claimed amount
            $table->decimal('claimed_amount', 10, 2)->nullable();
            
            // Drop column frame_amount and lens amount
            $table->dropColumn('frame_amount');
            $table->dropColumn('lens_amount');
        });
    }
};
