<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MigrationsService
{
    public static function getAllTables()
    {
        $tables = DB::select('SHOW TABLES');
        return array_map('current', $tables);
    }
}
