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
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id')->nullable()->after('clinic_id');
            $table->unsignedBigInteger('technician_id')->nullable()->after('workshop_id');
            $table->unsignedBigInteger('right_eye_lens_id')->nullable()->after('receipt_number');
            $table->unsignedBigInteger('left_eye_lens_id')->nullable()->after('right_eye_lens_id');
            $table->integer('quantity')->after('left_eye_lens_id')->default(0);
            $table->decimal('tat_one')->after('closed_date')->default(0);
            $table->decimal('tat_two')->after('tat_one')->default(0);
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreign('technician_id')->nullable()->references('id')->on('technicians')->onDelete('set null');
            $table->foreign('right_eye_lens_id')->nullable()->references('id')->on('lenses')->onDelete('cascade');
            $table->foreign('left_eye_lens_id')->nullable()->references('id')->on('lenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropForeign(['orders_user_id_foreign']);
            $table->dropColumn('user_id');
            $table->dropForeign(['orders_technician_id_foreign']);
            $table->dropColumn('technician_id');
            $table->dropForeign(['orders_right_eye_lens_id_foreign']);
            $table->dropColumn('right_eye_lens_id');
            $table->dropForeign(['orders_left_eye_lens_id_foreign']);
            $table->dropColumn('left_eye_lens_id');
            $table->dropColumn('quantity');
            $table->dropColumn('tat_one');
            $table->dropColumn('tat_two');
        });
    }
};
