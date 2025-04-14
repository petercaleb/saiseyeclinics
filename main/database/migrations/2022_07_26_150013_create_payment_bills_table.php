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
        Schema::create('payment_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('payment_details_id');
            $table->date('open_date');
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->string('consultation_receipt_number', 50)->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('lpo_number')->nullable();
            $table->string('approval_number')->nullable();
            $table->string('approval_status')->nullable();
            $table->string('bill_status')->nullable();
            $table->date('close_date')->nullable();
            $table->decimal('claimed_amount', 10, 2)->default(0);
            $table->decimal('agreed_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('remittance_amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->text('terms')->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('payment_details_id')->references('id')->on('payment_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_bills');
    }
};
