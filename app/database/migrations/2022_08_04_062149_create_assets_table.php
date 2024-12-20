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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('condition_id');
            $table->string('asset');
            $table->string('serial_number')->nullable();
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('asset_types')->onDelete('cascade');
            $table->foreign('condition_id')->references('id')->on('asset_conditions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
};
