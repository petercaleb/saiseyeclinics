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
        Schema::table('payment_bills', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_bills', function (Blueprint $table) {
            //
            $table->dropForeign('payment_bills_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
