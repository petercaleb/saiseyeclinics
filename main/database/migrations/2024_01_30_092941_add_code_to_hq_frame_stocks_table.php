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
        Schema::table('hq_frame_stocks', function (Blueprint $table) {
            //
            $table->string('code')->nullable()->after('frame_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hq_frame_stocks', function (Blueprint $table) {
            //
            $table->dropColumn('code');
        });
    }
};
