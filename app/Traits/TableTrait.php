<?php
// app/Traits/SortableTrait.php

namespace App\Traits;


use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;



trait TableTrait
{

    public $excelFile;
    public $temporaryExcelUrl;
    public $sortBy = "created_at";
    public $sortDirection = "ASC";
    public $filters = [];
    public $perPage="20";
    public $perPageOpations=["20"=>"20","50"=>"50","100"=>"100"];

public function setSortBy($chosenSortBy)
{
        if ($this->sortBy === $chosenSortBy) {
            $this->sortDirection = ($this->sortDirection === "ASC") ? "DESC" : "ASC";
            return;
        }
        $this->sortBy = $chosenSortBy;
        $this->sortDirection = "DESC";

    }
private function initializeFilter($name, $label, $data,$toTranslate=null)
{

        $this->filters[] = [
            'name' => $name,
            'label' => $label,
            'data' => $data,
            'toTranslate'=>$toTranslate
        ];
 }
private function updateFilterData($name, $newData)
 {
 foreach ($this->filters as &$filter) {
            if ($filter['name'] === $name) {
                $filter['data'] = $newData;
                break;
}
}
}


public function generateExcel($theMappingFunction, $fileName)
{
    // Your data retrieval logic, e.g., $tableData
    $tableData = $theMappingFunction(); // Execute the mapping function to get data

    try {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        // Define styles for header row
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        $columnIndex = 'A';
        foreach (array_keys($tableData[0]) as $header) {
            $activeWorksheet->setCellValue($columnIndex . '1', $header);
            $activeWorksheet->getStyle($columnIndex . '1')->applyFromArray($headerStyle);
            $columnIndex++;
        }
        // Add data rows and adjust column width

        $rowIndex = 2;
        foreach ($tableData as $row) {
            $columnIndex = 'A';
            foreach ($row as $cellValue) {
                $activeWorksheet
                ->setCellValue($columnIndex . $rowIndex, $cellValue);
                $activeWorksheet->getColumnDimension($columnIndex)
                ->setAutoSize(true); // Set auto width
                $activeWorksheet->getStyle($columnIndex . $rowIndex)
                ->getNumberFormat()
                ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                $columnIndex++;
            }
            $rowIndex++;
        }

        // Send the spreadsheet as a downloadable file
        $writer = new Xlsx($spreadsheet);
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName .'.xlsx"',
            ]
        );
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
}





public function generateEmptyExcelWithHeaders($fileName, $headers) {
    return $this->generateExcel(function() use($headers) {
            $data=[];
            foreach ($headers as $header){
                $data[0][$header]="";
            }
            return $data;

    }, $fileName);
}



public function uploadExcelFile($importClassName, $uploadMessage)
{
    try {
        $importClass = 'App\Imports\\' . $importClassName;
        $path = $this->excelFile->getRealPath();

        // Start a database transaction
        DB::beginTransaction();
        $data = Excel::toArray(new $importClass, $path)[0];
        foreach ($data as $lineNumber => $row) {
            $importInstance = new $importClass;
            $modalInstance = $importInstance->model($row, $lineNumber + 1);
            $modalInstance->save();
        }

        // Commit the database transaction if all saves were successful
        DB::commit();

        $this->dispatch('open-toast', $uploadMessage);
    } catch (\Exception $e) {
        // Rollback the database transaction if an exception occurs
        DB::rollBack();

        $this->dispatch('open-errors', [$e->getMessage()]);
    }
}

public function whenExcelFileUploaded($importClassName,$uploadMessage)
{
    if($this->excelFile){
            $extension = $this->excelFile->getClientOriginalExtension();
            $allowedExtensions = ['xlsx', 'xls', 'csv'];
    if (!in_array($extension, $allowedExtensions)) {
         $this->reset(['excelFile', 'temporaryExcelUrl']); // Clear uploaded file and temporary URL
        $this->dispatch('open-errors', [__("tables.common.excel-file-type-err")]);
        }else{
            $this->uploadExcelFile($importClassName,$uploadMessage);
        } }
}


}


