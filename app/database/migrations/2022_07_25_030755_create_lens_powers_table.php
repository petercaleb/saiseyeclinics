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
        Schema::create('lens_powers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('diagnoisis_id');
            $table->string('right_sphere');
            $table->string('right_cylinder');
            $table->string('right_axis');
            $table->string('right_add');
            $table->string('left_sphere');
            $table->string('left_cylinder');
            $table->string('left_axis');
            $table->string('left_add');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('diagnoisis_id')->references('id')->on('diagnoses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lens_powers');
    }
};
