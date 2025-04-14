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
        Schema::table('lens_receives', function (Blueprint $table) {
            //
            $table->boolean('received_status')->default(1)->after('is_hq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lens_receives', function (Blueprint $table) {
            //
            $table->dropColumn('received_status');
        });
    }
};
