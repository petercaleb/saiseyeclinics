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
            $table->dropColumn('power');
            $table->dropColumn('code');
            $table->dropForeign('lenses_lens_type_id_foreign');
            $table->dropColumn('lens_type_id');
            $table->dropForeign('lenses_lens_material_id_foreign');
            $table->dropColumn('lens_material_id');
            $table->dropColumn('lens_index');
            $table->dropColumn('date_added');
            $table->dropColumn('purchased');
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
            $table->string('power')->nullable()->after('workshop_id');
            $table->string('code')->nullable()->after('power');
            $table->unsignedBigInteger('lens_type_id')->nullable()->after('code');
            $table->unsignedBigInteger('lens_material_id')->nullable()->after('lens_type_id');
            $table->string('lens_index')->nullable()->after('lens_material_id');
            $table->date('date_added')->nullable()->after('lens_index');
            $table->integer('purchased')->nullable()->default(0)->after('opening');
            $table->foreign('lens_type_id')->nullable()->references('id')->on('lens_types')->onDelete('cascade');
            $table->foreign('lens_material_id')->nullable()->references('id')->on('lens_materials')->onDelete('cascade');
        });
    }
};
