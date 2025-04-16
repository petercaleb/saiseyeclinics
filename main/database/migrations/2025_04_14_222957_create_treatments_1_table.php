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

            $table->bigInteger('diagnosis_id')->nullable(); // Removed foreign key
            $table->bigInteger('power_id')->nullable(); // Removed foreign key
            $table->bigInteger('lens_prescription_id')->nullable(); // Removed foreign key
            $table->bigInteger('frame_prescription_id')->nullable(); // Removed foreign key
            $table->bigInteger('workshop_id')->nullable(); // Removed foreign key
            $table->bigInteger('order_id')->nullable(); // Removed foreign key

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
