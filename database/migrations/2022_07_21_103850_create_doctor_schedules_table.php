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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('user_id'); // Doctors or Optimists
            $table->unsignedBigInteger('patient_id'); // Patients
            $table->unsignedBigInteger('appointment_id'); // Patients
            $table->string('day'); // Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
            $table->date('date'); // 2020-07-21
            $table->time('time'); // 10:00:00
            $table->boolean('status')->default(0); // pending, confirmed, cancelled, completed
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
