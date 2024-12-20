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
        Schema::create('frame_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('frame_id');
            $table->string('gender');
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('shape_id');
            $table->integer('opening_stock');
            $table->integer('purchase_stock');
            $table->integer('total_stock');
            $table->integer('sold_stock');
            $table->integer('closing_stock');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('supplier_price', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('frame_colors')->onDelete('cascade');
            $table->foreign('shape_id')->references('id')->on('frame_shapes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_stocks');
    }
};
