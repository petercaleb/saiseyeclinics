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
        Schema::create('lens_powers_1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lens_power_id')->nullable();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('diagnoisis_id')->constrained()->onDelete('cascade');

            $table->string('right_sphere');
            $table->string('right_cylinder');
            $table->string('right_axis');
            $table->string('right_add');

            $table->string('left_sphere');
            $table->string('left_cylinder');
            $table->string('left_axis');
            $table->string('left_add');

            $table->text('notes')->nullable();

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
        Schema::dropIfExists('lens_powers_1');
    }
};
