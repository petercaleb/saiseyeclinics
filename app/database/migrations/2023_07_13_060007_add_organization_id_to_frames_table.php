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
        Schema::table('frames', function (Blueprint $table) {
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
        Schema::table('frames', function (Blueprint $table) {
            //
            $table->dropForeign('frames_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
};
