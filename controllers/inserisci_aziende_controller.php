<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class InserisciAziende extends AllFunctions
{



    function __construct()
    {
        parent::__construct();

    }









    public function aziende_massive_excel()
    {

        /* crea il file in excel */
        require_once $this->xlsx_library;

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
        $sheet->getStyle('B')->applyFromArray($styleArrayFirstColumn);


        /* blocco prima colonna */
        $sheet->freezePaneByColumnAndRow(3, 1);

        $spreadsheet->getActiveSheet()->mergeCells("A5:A8");
        $spreadsheet->getActiveSheet()->mergeCells("A9:A12");

        $address_type = ['', '', '', '', 'sede_legale', '', '', '', 'sede_operativa'];
        /* tipi indirizzo voci menu */
        $columnArray = array_chunk($address_type, 1);
        $spreadsheet->getActiveSheet()
                ->fromArray(
                        $columnArray, // The data to set
                        NULL, // Array values with this value will not be set
                        'A1'            // Top left coordinate of the worksheet range where
        );



        /* inserimento array verticale */
        $rowArray = [
            'nome',
            'ragione_sociale',
            'codice_fiscale',
            'partita_iva',
            'indirizzo',
            'cap',
            'citta',
            'provincia',
            'indirizzo',
            'cap',
            'citta',
            'provincia',
            'telefono',
            'cellulare',
            'email',
            'pec',
            'fax',
        ];

        /* voci menu */
        $columnArray = array_chunk($rowArray, 1);
        $spreadsheet->getActiveSheet()
                ->fromArray(
                        $columnArray, // The data to set
                        NULL, // Array values with this value will not be set
                        'B1'            // Top left coordinate of the worksheet range where
        );






        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $sheet->getStyle('A5:B8')->applyFromArray($styleArray);
        $sheet->getStyle('A9:B12')->applyFromArray($styleArray);



        /* larghezza colonne */
        $sheet->getColumnDimensionByColumn(1)->setWidth(15); /*  la prima colonna un po piu stretta */

        for ($i = 2; $i <= 702; $i++) /* da A a ZZ */
        {
            $sheet->getColumnDimensionByColumn($i)->setWidth(20);

            /* allineamento a sx altre colonne */
            $sheet->getStyle($i)->applyFromArray($styleArrayAllColumn);

            $sheet->getStyle($i)
                    ->getAlignment()->setWrapText(true); /* testo a capo */
        }



        for ($col = 2; $col <= 702; $col++)
        {

            for ($row = 1; $row <= 20; $row++)
            {
                /* Setto il formato stringa */
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, $row)
                        ->getNumberFormat()
                        ->setFormatCode(
                                \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT
                );
            }

//            /* Setto il formato data */
//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 4)
//                    ->getNumberFormat()
//                    ->setFormatCode(
//                            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
//            );
//
//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 12)
//                    ->getNumberFormat()
//                    ->setFormatCode(
//                            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
//            );
//
//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 13)
//                    ->getNumberFormat()
//                    ->setFormatCode(
//                            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
//            );
//
//            /* Setto il formato stringa */
//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 10)
//                    ->getNumberFormat()
//                    ->setFormatCode(
//                            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT
//            );
        }





        /* --------------------------------------------------------------- */
//        /* WORKSHEET DATI */
//        $datiWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Dati');
//        $spreadsheet->addSheet($datiWorkSheet, 1);
//
//
//        /* OPZIONI SESSO */
//        $rowArray = [
//            "M",
//            "F"
//        ];
//        /* inserimento array verticale */
//        $columnArray = array_chunk($rowArray, 1);
//        $spreadsheet->getSheet(1)
//                ->fromArray(
//                        $columnArray, // The data to set
//                        NULL, // Array values with this value will not be set
//                        'A1'            // Top left coordinate of the worksheet range where
//        );
//
//
//        $mansioni_all = $this->elenco_mansioni();
//
//        $mansioni = array();
//
//        foreach ($mansioni_all as $mansione)
//        {
//            $mansioni[] = $mansione['name'];
//        }
//
//        /* OPZIONI MANSIONI */
//        /* inserimento array verticale */
//        $rowArray = $mansioni; /* voci menu */
//        $columnArray = array_chunk($rowArray, 1);
//        $spreadsheet->getSheet(1)
//                ->fromArray(
//                        $columnArray, // The data to set
//                        NULL, // Array values with this value will not be set
//                        'B1'            // Top left coordinate of the worksheet range where
//        );



        /* -------------------------------------------------------------------------------------------------------- */

        $this->direct_download_excel($spreadsheet, "inserimento_aziende");

    }









}
