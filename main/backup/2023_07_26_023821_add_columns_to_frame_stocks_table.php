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
        Schema::table('frame_stocks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('organization_id')->after('id')->nullable();
            $table->unsignedBigInteger('brand_id')->after('clinic_id')->nullable();
            $table->unsignedBigInteger('type_id')->after('brand_id')->nullable();
            $table->unsignedBigInteger('size_id')->after('type_id')->nullable();
            $table->unsignedBigInteger('material_id')->after('size_id')->nullable();
            $table->string('code')->after('material_id')->nullable();
            $table->boolean('status')->after('remarks')->nullable()->default(1);
            $table->foreign('organization_id')->nullable()->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('brand_id')->nullable()->references('id')->on('frame_brands')->onDelete('cascade');
            $table->foreign('type_id')->nullable()->references('id')->on('frame_types')->onDelete('cascade');
            $table->foreign('size_id')->nullable()->references('id')->on('frame_sizes')->onDelete('cascade');
            $table->foreign('material_id')->nullable()->references('id')->on('frame_materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_stocks', function (Blueprint $table) {
            //
            $table->dropForeign('frame_stocks_organization_id_foreign');
            $table->dropColumn('organization_id');
            $table->dropForeign('frame_stocks_brand_id_foreign');
            $table->dropColumn('brand_id');
            $table->dropForeign('frame_stocks_type_id_foreign');
            $table->dropColumn('type_id');
            $table->dropForeign('frame_stocks_size_id_foreign');
            $table->dropColumn('size_id');
            $table->dropForeign('frame_stocks_material_id_foreign');
            $table->dropColumn('material_id');
            $table->dropColumn('code');
            $table->dropColumn('status');
        });
    }
};
