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
            $table->integer('received_stock')->after('transfered_stock')->default(0);
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
            $table->dropColumn('received_stock');
        });
    }
};
