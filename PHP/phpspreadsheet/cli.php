<?php

include 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$filePath = $argv[1];

$filename = __DIR__ . '/result.csv';

echo "Start: ". convert(memory_get_usage(true)) . PHP_EOL;

$reader = IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true);
$reader->setReadEmptyCells(true);
$spreadsheet = $reader->load($filePath);
$sheet = $spreadsheet->getActiveSheet();
$rowIterator = $sheet->getRowIterator();

$fp = fopen($filename, 'w');
foreach ($rowIterator as $rowIndex => $row) {
    $rowData = [];
    foreach ($row->getCellIterator() as $cellIndex => $cell) {
        if (!is_null($cell)) {
            $rowData[] = (string) $cell->getValue();
        }
    }

    if (!empty(array_diff($rowData, [null]))) {
        fputcsv($fp, $rowData, ';');
    }
}

fclose($fp);
echo "Done: ".convert(memory_get_usage(true)) . PHP_EOL;
echo "Peak: ".convert(memory_get_peak_usage(true)) . PHP_EOL;

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
