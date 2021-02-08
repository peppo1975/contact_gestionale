<? include '../controllers/inserisci_persone_controller.php'; ?>
<? $inserisci_persone = new InserisciPersone(); ?>
<?php

/*
  if(isset($_POST['']))
  {

  }

 */


if (isset($_POST['upload_excel']))
{
    //$inserisci_persone->write_file("_excel_file.txt", $_FILES);

    $FileName = "xlsx_" . uniqid();

    $inputFileName = __DIR__ . "/../files/upload/temp/{$FileName}";

    move_uploaded_file($_FILES['files']['tmp_name'][0], $inputFileName);

    $res = $inserisci_persone->read_vertical_xlsx($inputFileName);

    $_SESSION['inserisci_persone_massive']['elenco'] = $res;
    
    exec("rm -f {$inputFileName}");

    //$inserisci_persone->write_file("_insertimento", $res);
}


if (isset($_POST['elenco']))
{
    $elenco = $_SESSION['inserisci_persone_massive']['elenco'];

    ob_start();

    include_once '../modules/inserisci_persone_table_result.php';

    $html = ob_get_clean();

    print_r($html);
}


if (isset($_POST['annulla_inserimento']))
{
    unset($_SESSION['inserisci_persone_massive']['elenco']);
}



if (isset($_POST['conferma_inserimento']))
{
    $company = $_POST['conferma_inserimento'];
    
    $inserisci_persone->inserisci_persone_excel($company);
    
}






 
/* GENERA IL FILE EXCEL */

if (isset($_GET['persone_massive_excel']))
{
    $inserisci_persone->persone_massive_excel();
}

