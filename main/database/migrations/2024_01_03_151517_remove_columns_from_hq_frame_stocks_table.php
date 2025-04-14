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
            $table->dropColumn('closing');
            $table->dropColumn('remarks');
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
            $table->integer('closing')->after('total')->default(0);
            $table->text('remarks')->after('price')->nullable();
        });
    }
};
