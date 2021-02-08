<? include '../controllers/dati_generali_controller.php'; ?>
<? $dati_generali = new DatiGenerali(); ?>
<?php

/*
  if(isset($_POST['']))
  {

  }

 */

//header('Content-Type: application/json');

if (isset($_POST['cerca_comune']))
{
    $all = "";
    $find = $_POST['cerca_comune'];
    $res = $dati_generali->cerca_comune($find);

    if (count($res))
    {
        $all = $dati_generali->create_tab_list_comuni($res, $find);
    }

    header('Content-Type: application/json');
    print json_encode($all);
};


if (isset($_POST['seleziona_comune']))
{
    $id_comune = $_POST['seleziona_comune'];
    $res = $dati_generali->seleziona_comune($id_comune);
    header('Content-Type: application/json');
    print json_encode($res);
}

