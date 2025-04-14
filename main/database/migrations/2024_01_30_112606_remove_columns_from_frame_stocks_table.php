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
            $table->dropColumn('gender');
            $table->dropForeign('frame_stocks_color_id_foreign');
            $table->dropColumn('color_id');
            $table->dropForeign('frame_stocks_shape_id_foreign');
            $table->dropColumn('shape_id');
            $table->dropColumn('supplier_price');
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
            $table->string('gender')->after('code');
            $table->unsignedBigInteger('color_id')->after('gender');
            $table->unsignedBigInteger('shape_id')->after('color_id');
            $table->decimal('supplier_price', 8, 2)->after('total');
            $table->foreign('color_id')->references('id')->on('frame_colors')->onDelete('cascade');
            $table->foreign('shape_id')->references('id')->on('frame_shapes')->onDelete('cascade');
        });
    }
};
