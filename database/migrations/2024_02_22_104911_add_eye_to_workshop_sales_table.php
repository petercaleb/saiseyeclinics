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
        Schema::table('workshop_sales', function (Blueprint $table) {
            //
            $table->string('eye')->after('quantity')->nullable();
            $table->dropColumn('paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshop_sales', function (Blueprint $table) {
            //
            $table->dropColumn('eye');
            $table->decimal('paid', 10, 2)->default(0);
        });
    }
};
