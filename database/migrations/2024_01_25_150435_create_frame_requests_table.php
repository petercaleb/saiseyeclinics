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
        Schema::create('frame_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('frame_id');
            $table->date('request_date');
            $table->string('frame_code');
            $table->string('gender');
            $table->unsignedBigInteger("color_id");
            $table->unsignedBigInteger("shape_id");
            $table->integer('quantity')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('frame_colors')->onDelete('cascade');
            $table->foreign('shape_id')->references('id')->on('frame_shapes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frame_requests');
    }
};
