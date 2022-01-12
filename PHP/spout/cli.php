<?php

include 'vendor/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;


$filePath = $argv[1];

$filename = __DIR__ . '/result.csv';

echo "Start: ". convert(memory_get_usage(true)) . PHP_EOL;

$reader = ReaderEntityFactory::createXLSXReader();
$reader->open($filePath);

$fp = fopen($filename, 'w');
foreach ($reader->getSheetIterator() as $sheet) {
    foreach ($sheet->getRowIterator() as $row) {
        // do stuff with the row
        $rowData = [];
        $cells = $row->getCells();
        foreach ($cells as $cell) {
            if (!is_null($cell)) {
                if ($cell->getValue() instanceof DateTime){
                    $rowData[] = $cell->getValue()->format('d.m.Y H:i:s');
                } else {
                    $rowData[] = (string) $cell->getValue();
                }

            }
        }

        if (!empty(array_diff($rowData, [null]))) {
            fputcsv($fp, $rowData, ';');
        }
    }

    break; // Мы учитываем только первый лист
}
fclose($fp);
$reader->close();

echo "Done: ".convert(memory_get_usage(true)) . PHP_EOL;
echo "Peak: ".convert(memory_get_peak_usage(true)) . PHP_EOL;

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
