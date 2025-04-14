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
        Schema::create('bankings', function (Blueprint $table) {
            $table->id();
            $table->date('date_received')->nullable();
            $table->string('transaction_code');
            $table->tinyInteger('transaction_mode')->nullable();
            $table->unsignedBigInteger('insurance_id');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid', 10, 2)->nullable()->default(0);
            $table->decimal('balance', 10, 2)->nullable()->default(0);
            $table->tinyInteger('status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankings');
    }
};
