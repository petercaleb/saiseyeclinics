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
        Schema::table('lenses', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('hq_lens_id')->after('organization_id')->nullable();
            $table->foreign('hq_lens_id')->nullable()->references('id')->on('hq_lenses')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lenses', function (Blueprint $table) {
            //
            $table->dropForeign(['lenses_hq_lens_id_foreign']);
            $table->dropColumn('hq_stock_id');
        });
    }
};
