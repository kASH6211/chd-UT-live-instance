<?php
namespace App\Services;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModelValidationService
{
    public static function getValidationRules(string $table)
    {
        $rules = [];
     Schema::getColumnListing($table)
            ->map(function ($column) use (&$rules) {
                $columnRules = [];

                if ($column->getNotnull()) {
                    $columnRules[] = 'required';
                }

                // Add more rules based on column properties as needed
                // For example, you can check data type, length, unique, etc.

                $rules[$column->getName()] = implode('|', $columnRules);
            });

        return $rules;
    }
}
