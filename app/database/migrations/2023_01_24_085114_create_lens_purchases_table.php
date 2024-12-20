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
        Schema::create('lens_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('lens_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('purchased_date');
            $table->integer('quantity');
            $table->double('price', 10, 2)->default(0);
            $table->double('total_price', 10, 2)->default(0);
            $table->date('received_date');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('lens_id')->references('id')->on('lenses')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lens_purchases');
    }
};
