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
        Schema::create('frame_receiveds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id'); // HQ
            $table->unsignedBigInteger('clinic_id'); // clinic receiving frame
            $table->unsignedBigInteger('from_clinic_id')->nullable(); // Frame received from Clinic  
            $table->unsignedBigInteger('hq_frame_stock_id'); // stock HQ
            $table->unsignedBigInteger('user_id')->nullable(); // Doctor receiving the stock
            $table->unsignedBigInteger('frame_id');
            $table->string('frame_code');
            $table->date('received_date');
            $table->integer('quantity');
            $table->boolean('received_status')->default(1);
            $table->boolean('is_hq')->default(0); // 1 = HQ, 0 = Clinic
            $table->string('condition');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('from_clinic_id')->nullable()->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('hq_frame_stock_id')->references('id')->on('hq_frame_stocks')->onDelete('cascade');
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_receiveds');
    }
};
