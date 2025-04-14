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
        Schema::dropIfExists('remittances');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('remittances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('bill_id');
            $table->string('bill_invoice');
            $table->string('item');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->date('remittance_date')->nullable();
            $table->date('closed_date')->nullable();
            $table->string('status')->default('OPEN');
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('bill_id')->references('id')->on('payment_bills')->onDelete('cascade');
        });
    }
};
