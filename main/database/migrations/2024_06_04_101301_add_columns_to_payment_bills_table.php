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
            $table->dropColumn('remittance_amount');
            $table->dropColumn('remittance_balance');
            $table->tinyInteger('document_status')->nullable()->after('balance')->default(0);
            $table->date('send_date')->nullable()->after('document_status');
            $table->date('received_date')->nullable()->after('send_date');
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
            $table->decimal('remittance_amount', 10, 2)->nullable()->after('balance');
            $table->decimal('remittance_balance', 10, 2)->nullable()->after('remittance_amount');
            $table->dropColumn('document_status');
            $table->dropColumn('send_date');
            $table->dropColumn('received_date');
        });
    }
};
