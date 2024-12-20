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
        Schema::create('request_lenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('technician_id');
            $table->string('power');
            $table->unsignedBigInteger('lens_type_id');
            $table->unsignedBigInteger('lens_material_id');
            $table->string('lens_index');
            $table->string('eye');
            $table->date('date_requested')->nullable();
            $table->integer('quantity');
            $table->string('status')->default('REQUESTED');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('lens_type_id')->references('id')->on('lens_types')->onDelete('cascade');
            $table->foreign('lens_material_id')->references('id')->on('lens_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_lenses');
    }
};
