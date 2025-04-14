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
        Schema::create('received_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("banking_id");
            $table->unsignedBigInteger("remmittance_id");
            $table->unsignedBigInteger("paybill_id");
            $table->decimal('amount', 10, 2)->default(0)->nullable();
            $table->decimal('paid', 10, 2)->default(0)->nullable();
            $table->decimal('balance', 10, 2)->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign("banking_id")->references("id")->on("bankings")->onDelete("cascade");
            $table->foreign("remmittance_id")->references("id")->on("remmittances")->onDelete("cascade");
            $table->foreign("paybill_id")->references("id")->on("payment_bills")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_payments');
    }
};
