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
        Schema::table('frame_purchases', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('organization_id')->after('id')->nullable();
            $table->foreign('organization_id')->nullable()->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_purchases', function (Blueprint $table) {
            //
            $table->dropForeign('frame_purchases_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
};
