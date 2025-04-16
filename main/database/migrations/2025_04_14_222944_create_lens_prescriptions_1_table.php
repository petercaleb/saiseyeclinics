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
        Schema::create('lens_prescriptions_1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('power_id'); // Removed foreign key
            $table->bigInteger('type_id'); // Removed foreign key
            $table->bigInteger('material_id'); // Removed foreign key

            $table->string('index');
            $table->string('tint');
            $table->string('diameter');
            $table->string('focal_height');

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
        Schema::dropIfExists('lens_prescriptions_1');
    }
};
