<?php

// app/Console/Commands/GenerateValidationRules.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateValidationRules extends Command
{
    protected $signature = 'generate:rules {table}';

    protected $description = 'Generate validation rules based on the database table schema';

    public function handle()
    {
        $tableName = $this->argument('table');

        if (!Schema::hasTable($tableName)) {
            $this->error("Table '{$tableName}' does not exist.");
            return;
        }

        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        $rules = [];
        foreach ($columns as $column) {
            $columnRules = $this->generateRulesForColumn($tableName, $column);
            $rules[$column] = $columnRules;
        }

        $this->info("Validation rules for table '{$tableName}':");
        $this->info(print_r($rules, true));
    }

    private function generateRulesForColumn($table, $column)
    {
        $columnType = DB::getSchemaBuilder()->getColumnType($table, $column);

        $rules = [];

        switch ($columnType) {
            case 'string':
            case 'char':
                $rules[] = 'string';
                $rules[] = 'max:' . DB::getSchemaBuilder()->getColumnListing($table)->max($column);
                break;
            case 'integer':
                $rules[] = 'integer';
                break;
            case 'boolean':
                $rules[] = 'boolean';
                break;
            // Add more cases for other column types as needed
        }

        return implode('|', $rules);
    }
}
