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
        Schema::create('lens_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('power_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('material_id');
            $table->string('index');
            $table->string('tint');
            $table->string('diameter');
            $table->string('focal_height');
            $table->timestamps();
            $table->foreign('power_id')->references('id')->on('lens_powers')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('lens_types')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('lens_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lens_prescriptions');
    }
};
