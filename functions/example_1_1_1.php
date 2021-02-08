<? ?>

<? include '../controllers/inserisci_persone_massive_controller.php'; ?>
<? $inserisci_persone_massive = new InserisciPersoneMassive(); ?>

<?php

use PhpOffice\PhpSpreadsheet\IOFactory;




function g()
{
    require __DIR__ . '/../my/plugins/phpspreadsheet/vendor/autoload.php';

    $inputFileName = 'sample_my.xlsx';

    $spreadsheet = IOFactory::load($inputFileName);

    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, false, true);

    $temp = array();

    $len = 0;



    foreach ($sheetData as $row => $values_row)
    {
        foreach ($values_row as $col => $value)
        {
            $temp[$col][$row] = trim($value, " \t\n\r\0\x0B");
        }
    }

//print_r(count($sheetData[13]));

    $res = array();

    foreach ($temp as $col => $values_col)
    {
        foreach ($values_col as $row => $value)
        {
            if ($col == 'A')
            {
                if (strlen($value) > 0)
                {
                    $len = $row;
                }
                else
                {
                    unset($temp[$col][$row]);
                }
            }
            else
            {
                if ($row > $len)
                {
                    unset($temp[$col][$row]);
                }
                else
                {
                    $res[$col][$temp['A'][$row]] = $value;
                }
            }
        }
    }

    print_r($res);

    return $res;

//    $inserisci_persone_massive->write_file("_test_new_", $temp);
//    $inserisci_persone_massive->write_file("_test_new_2", $sheetData);
//    $inserisci_persone_massive->write_file("_test_new_3", $res);
}




$res = g();

$inserisci_persone_massive->write_file("_test_new_3", $res);

//}



