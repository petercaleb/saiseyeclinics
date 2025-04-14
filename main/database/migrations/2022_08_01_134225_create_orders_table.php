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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('payment_bill_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('lens_power_id');
            $table->unsignedBigInteger('lens_prescription_id');
            $table->unsignedBigInteger('frame_prescription_id');
            $table->date('order_date')->nullable();
            $table->string('receipt_number');
            // $table->string('order_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('closed_date')->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('payment_bill_id')->references('id')->on('payment_bills')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('lens_power_id')->references('id')->on('lens_powers')->onDelete('cascade');
            $table->foreign('lens_prescription_id')->references('id')->on('lens_prescriptions')->onDelete('cascade');
            $table->foreign('frame_prescription_id')->references('id')->on('frame_prescriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
