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
            $table->unsignedBigInteger('organization_id')->after('id')->nullable();
            $table->string('code')->after('frame_id');
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
        Schema::table('frame_stocks', function (Blueprint $table) {
            //
            $table->dropColumn('code');
            $table->dropForeign('frame_stocks_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
};
