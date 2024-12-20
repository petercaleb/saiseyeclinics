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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('payment_details_id')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->unsignedBigInteger('power_id')->nullable();
            $table->unsignedBigInteger('lens_prescription_id')->nullable();
            $table->unsignedBigInteger('frame_prescription_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('bill_status')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->decimal('claimed_amount', 10, 2)->default(0);
            $table->decimal('agreed_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('order_status')->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->nullable()->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('patient_id')->nullable()->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->nullable()->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('payment_details_id')->nullable()->references('id')->on('payment_details')->onDelete('cascade');
            $table->foreign('schedule_id')->nullable()->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('diagnosis_id')->nullable()->references('id')->on('diagnoses')->onDelete('cascade');
            $table->foreign('power_id')->nullable()->references('id')->on('lens_powers')->onDelete('cascade');
            $table->foreign('lens_prescription_id')->nullable()->references('id')->on('lens_prescriptions')->onDelete('cascade');
            $table->foreign('frame_prescription_id')->nullable()->references('id')->on('frame_prescriptions')->onDelete('cascade');
            $table->foreign('bill_id')->nullable()->references('id')->on('payment_bills')->onDelete('cascade');
            $table->foreign('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
