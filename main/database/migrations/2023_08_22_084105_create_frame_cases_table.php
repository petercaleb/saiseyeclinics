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
        Schema::create('frame_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('shape_id');
            $table->string('code')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('color_id')->references('id')->on('case_colors')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('case_sizes')->onDelete('cascade');
            $table->foreign('shape_id')->references('id')->on('case_shapes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_cases');
    }
};
