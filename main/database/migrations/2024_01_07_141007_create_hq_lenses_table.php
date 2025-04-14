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
        Schema::create('hq_lenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('power');
            $table->string('code')->unique();
            $table->unsignedBigInteger('lens_type_id');
            $table->unsignedBigInteger('lens_material_id');
            $table->string('lens_index');
            $table->date('date_added');
            $table->string('eye');
            $table->integer('opening')->default(0);
            $table->integer('purchased')->default(0);
            $table->integer('transfered')->default(0);
            $table->integer('total')->default(0);
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('lens_type_id')->references('id')->on('lens_types')->onDelete('cascade');
            $table->foreign('lens_material_id')->references('id')->on('lens_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hq_lenses');
    }
};
