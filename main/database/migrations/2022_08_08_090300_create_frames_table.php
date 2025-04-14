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
        Schema::create('frames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('material_id');
            $table->string('code')->unique();
            $table->string('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('frame_brands')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('frame_types')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('frame_sizes')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('frame_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frames');
    }
};
