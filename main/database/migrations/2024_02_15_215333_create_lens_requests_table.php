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
        Schema::create('lens_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('hq_lens_id');
            $table->string('lens_code');
            $table->date('request_date');
            $table->integer('quantity')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('transfer_status')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('hq_lens_id')->references('id')->on('hq_lenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lens_requests');
    }
};
