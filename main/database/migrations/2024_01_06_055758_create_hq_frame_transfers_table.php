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
        Schema::create('hq_frame_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('admin_id'); // Transfered by
            $table->unsignedBigInteger('to_clinic_id'); //Clinic  Transfering to
            $table->unsignedBigInteger('stock_id');
            $table->string('frame_code');
            $table->date('transfer_date');
            $table->integer('quantity');
            $table->boolean('transfer_status')->default(0); //Transfered | Not Transfered
            $table->string('condition');
            $table->boolean('received_status')->default(0); // Received | Not Received
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('to_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('hq_frame_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hq_frame_transfers');
    }
};
