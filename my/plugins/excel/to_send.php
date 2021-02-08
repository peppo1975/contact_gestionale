<? session_start(); ?>

<?php

include_once('PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

$inputFileName = $_POST['file_name'];



$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

$_SESSION['to_send'] = array();
$read = true;
$index = 2;
//print_r($_POST);
//die();
do
{

    $cognome = (string) $objPHPExcel->getActiveSheet()->getCell("A{$index}")->getValue();
    $nome = (string) $objPHPExcel->getActiveSheet()->getCell("B{$index}")->getValue();
    $cf = (string) $objPHPExcel->getActiveSheet()->getCell("C{$index}")->getValue();
    $data_nascita = (string) $objPHPExcel->getActiveSheet()->getCell("D{$index}")->getValue();
    $email = (string) $objPHPExcel->getActiveSheet()->getCell("E{$index}")->getValue();

    $to_send = array();

    if ($cognome != "")
    {
        $to_send['cognome'] = trim($cognome, ' ');
        $to_send['nome'] = trim($nome, ' ');
        $to_send['cf'] = trim($cf, ' ');
        $to_send['data_nascita'] = trim($data_nascita, ' ');
        $to_send['email'] = trim($email, ' ');


        $_SESSION['to_send'][] = $to_send;
    }
    else
    {
        $read = false;
    }



    $index++;
}
while ($read);


print_r($_SESSION);
