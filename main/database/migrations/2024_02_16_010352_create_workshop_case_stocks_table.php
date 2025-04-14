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
        Schema::create('workshop_case_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('hq_stock_id');
            $table->unsignedBigInteger('case_id');
            $table->string('code');
            $table->integer('opening');
            $table->integer('received');
            $table->integer('transfered');
            $table->integer('total');
            $table->integer('sold');
            $table->integer('closing');
            $table->decimal('price', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('hq_stock_id')->references('id')->on('hq_case_stocks')->onDelete('cascade');
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
        Schema::dropIfExists('workshop_case_stocks');
    }
};
