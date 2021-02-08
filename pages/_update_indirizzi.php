<? include '../controllers/all_functions_controller.php'; ?>
<?php

$all_functions = new AllFunctions();


if (isset($_POST['indirizzi_aziende']))
{
    $elenco_aziende = $_POST['indirizzi_aziende'];

    // print_r($elenco_aziende);
    // die();

    foreach ($elenco_aziende as $key => $azienda)
    {
        $table = "companies";

        $array_values = $azienda;

        $filter = "company";

        $value_filter = $key;

        // print "\n{$key}\n";

        print_r($array_values);

        print_r($all_functions->edit($table, $array_values, $filter, $value_filter));
    }
}
