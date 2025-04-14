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
        Schema::create('contact_lens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('material_id');
            $table->string('item_code')->unique();
            $table->string('photo')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
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
        Schema::dropIfExists('contact_lens');
    }
};
