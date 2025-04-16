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
        Schema::create('treatments_1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('treatment_id')->nullable();

            $table->foreignId('diagnosis_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('power_id')->nullable()->constrained('lens_powers_1')->onDelete('cascade');
            $table->foreignId('lens_prescription_id')->nullable()->constrained('lens_prescriptions_1')->onDelete('cascade');
            $table->foreignId('frame_prescription_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('workshop_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('payments')->default('consultation');
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatments_1');
    }
};
