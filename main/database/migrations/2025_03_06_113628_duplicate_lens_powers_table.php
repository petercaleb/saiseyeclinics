<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('lens_powers_1', function (Blueprint $table) {
            $columns = DB::getSchemaBuilder()->getColumnListing('lens_powers');

            foreach ($columns as $column) {
                if (!in_array($column, ['id', 'created_at', 'updated_at'])) { // Exclude duplicate columns
                    $type = DB::getSchemaBuilder()->getColumnType('lens_powers', $column);

                    switch ($type) {
                        case 'bigint':
                            $table->bigInteger($column);
                            break;
                        case 'int':
                            $table->integer($column);
                            break;
                        case 'varchar':
                            $table->string($column);
                            break;
                        case 'text':
                            $table->text($column);
                            break;
                        case 'datetime':
                            $table->dateTime($column);
                            break;
                        default:
                            $table->string($column);
                    }
                }
            }

            // Add timestamps only if they don't exist already
            if (!in_array('created_at', $columns) && !in_array('updated_at', $columns)) {
                $table->timestamps();
            }
        });

        $columns = DB::getSchemaBuilder()->getColumnListing('lens_powers');
        $excludedColumns = ['id', 'created_at', 'updated_at']; // Exclude unnecessary columns

        // Keep only columns that exist in both tables
        $columnsToCopy = array_diff($columns, $excludedColumns);
        $columnsList = implode(',', $columnsToCopy);

        // Insert data explicitly matching columns
        DB::statement("INSERT INTO lens_powers_1 ($columnsList) SELECT $columnsList FROM lens_powers");
    }

    public function down()
    {
        Schema::dropIfExists('lens_powers_1');
    }
};
