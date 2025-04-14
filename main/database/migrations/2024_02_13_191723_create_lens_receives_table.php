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
        Schema::create('lens_receives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('from_workshop_id')->nullable();
            $table->unsignedBigInteger('hq_lens_id');
            $table->unsignedBigInteger('technician_id');
            $table->string('lens_code');
            $table->date('received_date');
            $table->integer('quantity')->default(0);
            $table->boolean('is_hq')->default(1);
            $table->string('condition');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('from_workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('hq_lens_id')->references('id')->on('hq_lenses')->onDelete('cascade');
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lens_receives');
    }
};
