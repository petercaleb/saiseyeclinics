<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        // Create the lens_powers_1 table like lens_powers
        DB::statement('CREATE TABLE lens_powers_1 LIKE lens_powers');
    }

    public function down()
    {
        // Drop the lens_powers_1 table if rolling back the migration
        Schema::dropIfExists('lens_powers_1');
    }
};
