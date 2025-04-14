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
        Schema::create('remmittances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_bill_id');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->foreign('payment_bill_id')->references('id')->on('payment_bills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remmittances');
    }
};
