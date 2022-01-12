<?php

include 'vendor/autoload.php';

$filePath = $argv[1];

$filename = __DIR__ . '/result.csv';

echo "Start: ". convert(memory_get_usage(true)) . PHP_EOL;

$fp = fopen($filename, 'w');
if ( $xlsx = SimpleXLSX::parse( $filePath) ) {
    foreach ( $xlsx->rows() as $r => $row ) {
        $rowData = [];
        foreach ( $row as $c => $cell ) {
            $rowData[] = (string) $cell;
        }

        if (!empty(array_diff($rowData, [null]))) {
            fputcsv($fp, $rowData, ';');
        }
    }
} else {
    echo SimpleXLSX::parseError();
}

fclose($fp);

echo "Done: ".convert(memory_get_usage(true)) . PHP_EOL;
echo "Peak: ".convert(memory_get_peak_usage(true)) . PHP_EOL;

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
