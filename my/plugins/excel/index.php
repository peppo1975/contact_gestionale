<?php

include_once('PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

$inputFileName = 'template.xlsx';

/* check point */

// Read the existing excel file
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
// Add column headers
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', "3")
        ->setCellValue('C2', "10")
        ->setCellValue('B2', "99")
        ->setCellValue('D2', "77");



$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A4:E10')->applyFromArray($styleThinBlackBorderOutline);

// Generate an updated excel file
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=out.xlsx');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
