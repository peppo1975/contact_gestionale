<? include '../controllers/inserisci_persone_massive_controller.php'; ?>
<? $inserisci_persone_massive = new InserisciPersoneMassive(); ?>
<?php

require __DIR__ . '/../my/plugins/phpspreadsheet/vendor/autoload.php';

//s

/* stile */
$styleArrayFirstColumn = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];

$styleArrayAllColumn = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];


$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

/* stile grassetto e allineamento a sx prima colonna */
$sheet->getStyle('A')->applyFromArray($styleArrayFirstColumn);


/* blocco prima colonna */
$sheet->freezePaneByColumnAndRow(2, 1);

/* inserimento array verticale */
$rowArray = [
    'cognome',
    'nome',
    'sesso',
    'data_nascita',
    'citta_nascita',
    'provincia_nascita',
    'citta_residenza',
    'provincia_residenza',
    'indirizzo_residenza',
    'cf',
    'mansione'
];

/* voci menu */
$columnArray = array_chunk($rowArray, 1);
$spreadsheet->getActiveSheet()
        ->fromArray(
                $columnArray, // The data to set
                NULL, // Array values with this value will not be set
                'A1'            // Top left coordinate of the worksheet range where
);


/* larghezza colonne */
for ($i = 1; $i <= 702; $i++) /* da A a ZZ */
{
    $sheet->getColumnDimensionByColumn($i)->setWidth(20);

    /* allineamento a sx altre colonne */
    $sheet->getStyle($i)->applyFromArray($styleArrayAllColumn);

    $sheet->getStyle($i)
            ->getAlignment()->setWrapText(true); /* testo a capo */
}



for ($col = 2; $col <= 702; $col++)
{
//    getCellByColumnAndRow($col, $row)

    /* SESSO */
    $validation = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, 3)->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Input error');
    $validation->setError('Value is not in list.');
    $validation->setPromptTitle('Seleziona dall\'elenco');
    $validation->setPrompt('Per favore, seleziona un valore dall\'elenco a discesa');
    $validation->setFormula1('Dati!$A$1:$A$2');

    /* Mansioni */
    $validation = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($col, 11)->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Input error');
    $validation->setError('Value is not in list.');
    $validation->setPromptTitle('Seleziona dall\'elenco');
    $validation->setPrompt('Per favore, seleziona un valore dall\'elenco a discesa');
    $validation->setFormula1('Dati!$B:$B');


    /* Setto il formato data */
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 4)
            ->getNumberFormat()
            ->setFormatCode(
                    \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
    );

    /* Setto il formato stringa */
    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 10)
            ->getNumberFormat()
            ->setFormatCode(
                    \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT
    );
}





/* --------------------------------------------------------------- */
/* WORKSHEET DATI */
$datiWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Dati');
$spreadsheet->addSheet($datiWorkSheet, 1);


/* OPZIONI SESSO */
$rowArray = [
    "M",
    "F"
];
/* inserimento array verticale */
$columnArray = array_chunk($rowArray, 1);
$spreadsheet->getSheet(1)
        ->fromArray(
                $columnArray, // The data to set
                NULL, // Array values with this value will not be set
                'A1'            // Top left coordinate of the worksheet range where
);


$mansioni_all = $inserisci_persone_massive->elenco_mansioni();

$mansioni = array();

foreach ($mansioni_all as $mansione)
{
    $mansioni[] = $mansione['name'];
}

/* OPZIONI MANSIONI */
/* inserimento array verticale */
$rowArray = $mansioni; /* voci menu */
$columnArray = array_chunk($rowArray, 1);
$spreadsheet->getSheet(1)
        ->fromArray(
                $columnArray, // The data to set
                NULL, // Array values with this value will not be set
                'B1'            // Top left coordinate of the worksheet range where
);



/* -------------------------------------------------------------------------------------------------------- */




$filename = 'sample-' . time() . '.xlsx';
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
