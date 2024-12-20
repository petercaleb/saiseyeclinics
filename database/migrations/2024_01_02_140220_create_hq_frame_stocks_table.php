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
        Schema::create('hq_frame_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("organization_id");
            $table->unsignedBigInteger("admin_id");
            $table->unsignedBigInteger("frame_id");
            $table->string('gender')->nullable();
            $table->unsignedBigInteger("color_id");
            $table->unsignedBigInteger("shape_id");
            $table->integer('opening')->default(0);
            $table->integer('purchased')->default(0);
            $table->integer('transfered')->default(0);
            $table->integer('total')->default(0);
            $table->integer('closing')->default(0);
            $table->decimal('supplier_price', 10, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('hq_frame_stocks');
    }
};
