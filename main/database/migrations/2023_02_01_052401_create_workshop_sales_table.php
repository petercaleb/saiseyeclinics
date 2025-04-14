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
        Schema::create('workshop_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('lens_id');
            $table->unsignedBigInteger('payment_bill_id');
            $table->integer('quantity');
            $table->decimal('paid', 10, 2)->default(0);
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('lens_id')->references('id')->on('lenses')->onDelete('cascade');
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
        Schema::dropIfExists('workshop_sales');
    }
};
