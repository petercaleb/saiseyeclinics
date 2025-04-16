<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create the treatments_1 table like treatments
        DB::statement('CREATE TABLE treatments_1 LIKE treatments');
    }

    public function down()
    {
        // Drop the treatments_1 table if rolling back the migration
        Schema::dropIfExists('treatments_1');
    }
};
