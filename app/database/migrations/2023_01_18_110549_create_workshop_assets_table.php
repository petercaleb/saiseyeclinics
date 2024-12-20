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
        Schema::create('workshop_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('condition_id');
            $table->string('asset');
            $table->string('serial_number');
            $table->integer('quantity');
            $table->text('description');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->default(0);
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
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
        Schema::dropIfExists('workshop_assets');
    }
};
