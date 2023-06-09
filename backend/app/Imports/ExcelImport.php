<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return [
            'code' => $row['code'],
            'last_name' => $row['last_name'],
            'first_name' => $row['first_name'],
            'created_at' => $row['created_at'],
            'observations' => $row['observations']
            // add more fields here as needed
        ];
    }
}
