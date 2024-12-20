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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('from_clinic_id');
            $table->unsignedBigInteger('to_clinic_id');
            $table->date('transfer_date');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('condition_id');
            $table->integer('quantity');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
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
        Schema::dropIfExists('asset_transfers');
    }
};
