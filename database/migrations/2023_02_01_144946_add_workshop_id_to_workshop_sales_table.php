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
        Schema::table('workshop_sales', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('workshop_id')->nullable()->after('organization_id');
            $table->foreign('workshop_id')->nullable()->references('id')->on('workshops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshop_sales', function (Blueprint $table) {
            //
            $table->dropForeign('workshop_sales_workshop_id_foreign');
            $table->dropColumn('workshop_id');
        });
    }
};
