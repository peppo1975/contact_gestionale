<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InserisciPersone extends AllFunctions
{




    function __construct()
    {
        parent::__construct();
    }




    public function inserisci_persone_excel($company)
    {
//        $this->write_file("preinserimento", $_SESSION['inserisci_persone_massive']['elenco']);

        $mansioni = $this->elenco_chiavi_mansioni();

//        $this->write_file("mansioni", $mansioni);

        foreach ($_SESSION['inserisci_persone_massive']['elenco'] as $key => $persona)
        {

            /* inserisco le persone */

            $mansione = $persona['mansione'];
            unset($persona['mansione']);
            $data_assunzione = $persona['data_assunzione'];
            unset($persona['data_assunzione']);
            $data_licenziamento = $persona['data_licenziamento'];
            unset($persona['data_licenziamento']);


            $persona['data_nascita'] = $this->parse_date_excel_to_timestamp($persona['data_nascita']);

            $table = 'peoples';
            $values = $persona;
            $res = $this->insert_into($table, $values, true);

            /*  */

            $company_people = array();
            $company_people['people'] = $res['last_id'];
            $company_people['company'] = $company;
            $company_people['title'] = "3";
            $company_people['task'] = $mansioni[$mansione]['task'];
            $company_people['assumption_date'] = $this->parse_date_excel_to_timestamp($data_assunzione);
            if (strlen($data_licenziamento) > 0)
                $company_people['dismissal_date'] = $this->parse_date_excel_to_timestamp($data_licenziamento);

            $table = 'company_people';
            $values = $company_people;
            $this->insert_into($table, $values);

//            print_r($res);
        }
    }




    public function persone_massive_excel()
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
            'mansione',
            'data_assunzione',
            'data_licenziamento',
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

            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 12)
                    ->getNumberFormat()
                    ->setFormatCode(
                            \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
            );

            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($col, 13)
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


        $mansioni_all = $this->elenco_mansioni();

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

        $this->direct_download_excel($spreadsheet, "inserimento_persone");
    }




}

