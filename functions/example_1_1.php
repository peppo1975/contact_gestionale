<?php

require __DIR__ . '/../my/plugins/phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

//$inputFileName = __DIR__ . '/../my/plugins/phpspreadsheet/vendor/phpoffice/phpspreadsheet/samples/Reader/sampleData/example1.xls';
$inputFileName = __DIR__ . '/sample_my.xlsx';

//$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using ' . Xls::class);
$reader = new Xlsx();
$spreadsheet = $reader->load($inputFileName);

$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//$sheetData2 = $spreadsheet->getActiveSheet()->getCell("A1")->getValue();
//$sheetData3 = $spreadsheet->getSheet(2)->getCell("A1")->getValue();
//
//
//$sheetData4 = $spreadsheet->getSheet(2)->toArray(null, true, true, true);
//var_dump($sheetData);
//
//print_r($sheetData);
//
//print_r($sheetData2);
//
//print_r($sheetData3);

//print_r($sheetData4);

$res = array();

foreach ($sheetData as $row => $values_row)
{
    foreach ($values_row as $col=>$value)
    {
        $res[$col][$row] = $value;
    }
}

print_r($res);