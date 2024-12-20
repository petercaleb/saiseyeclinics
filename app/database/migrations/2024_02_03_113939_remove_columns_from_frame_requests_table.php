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
        Schema::table('frame_requests', function (Blueprint $table) {
            //
            $table->dropColumn('gender');
            $table->dropForeign('frame_requests_color_id_foreign');
            $table->dropColumn('color_id');
            $table->dropForeign('frame_requests_shape_id_foreign');
            $table->dropColumn('shape_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_requests', function (Blueprint $table) {
            //
            $table->string('gender')->nullable()->after('frame_code');
            $table->unsignedBigInteger('color_id')->nullable()->after('gender');
            $table->unsignedBigInteger('shape_id')->nullable()->after('color_id');
            $table->foreign('color_id')->nullable()->references('id')->on('frame_colors')->onDelete('set null');
            $table->foreign('shape_id')->nullable()->references('id')->on('frame_shapes')->onDelete('set null');
        });
    }
};
