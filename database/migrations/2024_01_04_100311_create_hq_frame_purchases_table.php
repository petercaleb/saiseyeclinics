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
        Schema::create('hq_frame_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->unsignedBigInteger('frame_id')->nullable();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('shape_id')->nullable();
            $table->string('receipt_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('gender')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('attachment')->nullable(); // Attach 
            $table->timestamps();
            $table->foreign('organization_id')
                ->nullable()
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
            $table->foreign('admin_id')
                ->nullable()
                ->references('id')
                ->on('admins')
                ->onDelete('cascade');
            $table->foreign('stock_id')
                ->nullable()
                ->references('id')
                ->on('hq_frame_stocks')
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
            $table->foreign('vendor_id')
                ->nullable()
                ->references('id')
                ->on('vendors')
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
        Schema::dropIfExists('hq_frame_purchases');
    }
};
