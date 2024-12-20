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
        Schema::create('frame_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('power_id');
            $table->unsignedBigInteger('prescription_id');
            $table->string('frame_code');
            $table->string('receipt_number');
            $table->unsignedBigInteger('workshop_id');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('power_id')->references('id')->on('lens_powers')->onDelete('cascade');
            $table->foreign('prescription_id')->references('id')->on('lens_prescriptions')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_prescriptions');
    }
};
