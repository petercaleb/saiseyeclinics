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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->unsignedBigInteger('power_id')->nullable();
            $table->unsignedBigInteger('lens_prescription_id')->nullable();
            $table->unsignedBigInteger('frame_prescription_id')->nullable();
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->string('payments')->default('consultation');
            $table->string('status');
            $table->timestamps();
            $table->foreign('diagnosis_id')->nullable()->references('id')->on('diagnoses')->onDelete('cascade');
            $table->foreign('power_id')->nullable()->references('id')->on('lens_powers')->onDelete('cascade');
            $table->foreign('lens_prescription_id')->nullable()->references('id')->on('lens_prescriptions')->onDelete('cascade');
            $table->foreign('frame_prescription_id')->nullable()->references('id')->on('frame_prescriptions')->onDelete('cascade');
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
        Schema::dropIfExists('treatments');
    }
};
