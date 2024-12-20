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
        Schema::create('received_frames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('from_clinic_id');
            $table->unsignedBigInteger('to_clinic_id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('transfer_id');
            $table->unsignedBigInteger('transfer_user_id');
            $table->unsignedBigInteger('received_user_id');
            $table->timestamp('received_date');
            $table->string('frame_code');
            $table->integer('quantity');
            $table->string('received_status');
            $table->string('condition');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('from_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('to_clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('stock_id')->references('id')->on('frame_stocks')->onDelete('cascade');
            $table->foreign('transfer_id')->references('id')->on('frame_transfers')->onDelete('cascade');
            $table->foreign('transfer_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('received_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_frames');
    }
};
