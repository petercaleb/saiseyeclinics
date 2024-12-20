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
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('treatment_id')->after('diagnosis_id')->nullable();
            $table->foreign('treatment_id')->nullable()->references('id')->on('treatments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->dropForeign('reports_treatment_id_foreign');
            $table->dropColumn('treatment_id');
        });
    }
};
