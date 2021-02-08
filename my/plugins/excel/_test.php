<? session_start(); ?>

<?php

$key = "21/01/1975";
$expl = explode("/", $key);
print_r($expl);

if ((is_numeric($expl[0])) && (is_numeric($expl[1])) && (is_numeric($expl[2])))
{
    print "fengul";
}

//print is_numeric($element);

//is_numeric("2");

die();
include_once('PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php');

//$inputFileName = $_POST['file_name'];
$inputFileName = '_test.xlsx';


$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

file_put_contents("_test.txt", print_r($objPHPExcel, true));

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


