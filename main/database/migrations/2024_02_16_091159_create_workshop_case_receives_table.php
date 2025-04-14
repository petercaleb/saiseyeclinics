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
        Schema::create('workshop_case_receives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('from_workshop_id')->nullable();
            $table->unsignedBigInteger('hq_case_stock_id');
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->unsignedBigInteger('case_id');
            $table->string('case_code');
            $table->date('receive_date');
            $table->integer('quantity');
            $table->boolean('received_status')->default(0);
            $table->boolean('is_hq')->default(0);
            $table->string('condition')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('from_workshop_id')->nullable()->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('hq_case_stock_id')->references('id')->on('hq_case_stocks')->onDelete('cascade');
            $table->foreign('technician_id')->nullable()->references('id')->on('technicians')->onDelete('set null');
            $table->foreign('case_id')->references('id')->on('frame_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshop_case_receives');
    }
};
