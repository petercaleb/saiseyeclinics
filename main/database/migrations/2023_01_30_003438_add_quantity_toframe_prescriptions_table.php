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
            $table->integer('quantity')->default(0)->after('workshop_id');
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
            $table->dropColumn('quantity');
        });
    }
};
