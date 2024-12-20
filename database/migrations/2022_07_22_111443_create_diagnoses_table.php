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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id'); // Clinic The Patient is being diagnosed in.
            $table->unsignedBigInteger('user_id'); // Doctor Diagnosing the patient
            $table->unsignedBigInteger('patient_id'); // Patient being diagnosed.
            $table->unsignedBigInteger('appointment_id'); // Appointment the patient is being diagnosed in.
            $table->unsignedBigInteger('schedule_id'); // Schedule the patient is being diagnosed in.
            $table->text('signs');
            $table->text('symptoms');
            $table->text('diagnosis');
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
};
