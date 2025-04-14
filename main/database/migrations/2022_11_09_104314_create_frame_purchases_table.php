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
        Schema::create('frame_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->unsignedBigInteger('frame_id')->nullable();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('shape_id')->nullable();
            $table->string('receipt_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->timestamps();
            $table->foreign('stock_id')
                ->nullable()
                ->references('id')
                ->on('frame_stocks')
                ->onDelete('cascade');
            $table->foreign('frame_id')
                ->nullable()
                ->references('id')
                ->on('frames')
                ->onDelete('cascade');
            $table->foreign('color_id')
                ->nullable()
                ->references('id')
                ->on('frame_colors')
                ->onDelete('cascade');  
            $table->foreign('shape_id')
                ->nullable()
                ->references('id')
                ->on('frame_shapes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_purchases');
    }
};
