<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class EmiRepository
{
    public function dropTable()
    {
        DB::statement('DROP TABLE IF EXISTS emi_details');
    }

    public function createTable(array $months)
    {
        $columns = array_map(fn($month) => "`$month` DECIMAL(10,2) DEFAULT 0.00", $months);
        $columnsSql = implode(',', $columns);

        DB::statement("CREATE TABLE emi_details (
            clientid INT PRIMARY KEY,
            $columnsSql
        )");
    }

    public function insertRow(array $row)
    {
        $columnsInsert = implode(',', array_keys($row));
        $valuesInsert = implode(',', array_map(fn($v) => is_numeric($v) ? $v : "'$v'", $row));
        DB::statement("INSERT INTO emi_details ($columnsInsert) VALUES ($valuesInsert)");
    }
    public function insertMany(array $rows)
    {
        if (empty($rows)) {
            return;
        }

        $columns = array_keys($rows[0]);

        // Build multiple value sets
        $valuesSql = [];
        foreach ($rows as $row) {
            $valuesSql[] = '(' . implode(',', array_map(
                fn($v) => is_numeric($v) ? $v : "'$v'",
                $row
            )) . ')';
        }

        $columnsInsert = implode(',', $columns);
        $valuesInsert  = implode(',', $valuesSql);

        DB::statement("INSERT INTO emi_details ($columnsInsert) VALUES $valuesInsert");
    }
    public function getAll()
    {
        return DB::table('emi_details')->get();
    }

    public function exists()
    {
        return \Schema::hasTable('emi_details');
    }
}
