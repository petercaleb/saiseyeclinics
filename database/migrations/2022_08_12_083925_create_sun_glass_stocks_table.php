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
        Schema::create('sun_glass_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('glass_id');
            $table->unsignedBigInteger('color_id');
            $table->string('gender');
            $table->unsignedBigInteger('shape_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('opening_stock');
            $table->unsignedBigInteger('purchase_stock');
            $table->unsignedBigInteger('total_stock');
            $table->unsignedBigInteger('sold_stock');
            $table->unsignedBigInteger('closing_stock');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('supplier_price', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('glass_id')->references('id')->on('sun_glasses')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('shape_id')->references('id')->on('shapes')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sun_glass_stocks');
    }
};
