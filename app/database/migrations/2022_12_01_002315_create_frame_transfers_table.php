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
        Schema::create('frame_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('from_clinic_id');
            $table->unsignedBigInteger('to_clinic_id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('transfer_user_id'); // Doctor who has transfered 
            $table->string('frame_code');
            $table->date('transfer_date');
            $table->integer('quantity');
            $table->string('transfer_status');
            $table->string('condition');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('from_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('to_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('frame_stocks')->onDelete('cascade');
            $table->foreign('transfer_user_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_transfers');
    }
};
