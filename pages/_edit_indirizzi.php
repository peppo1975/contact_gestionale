<? include '../controllers/all_functions_controller.php'; ?>
<?php
$all_functions = new AllFunctions();

$elenco_aziende = $all_functions->elenco_aziende();

$res = array();
//print_r($elenco_aziende);

foreach ($elenco_aziende as $key => $azienda)
{

    $nome = $azienda['name'];

    $legal_site_json = "";
    $operative_site_json = "";

    if (!base64_decode($azienda['legal_site'], true))
    {
        unset($elenco_aziende[$key]['legal_site']);
    }
    else
    {
        $legal_site = unserialize(base64_decode($azienda['legal_site']));
        $legal_site['CAP'] = "";
        $legal_site_json = (addslashes(json_encode($legal_site)));
        $res[$key]['legal_site'] = $legal_site_json;
    }

    
    
    if (!base64_decode($azienda['operative_site'], true))
    {
        unset($elenco_aziende[$key]['operative_site']);
    }
    else
    {
        $operative_site = unserialize(base64_decode($azienda['operative_site']));
        $operative_site['CAP'] = "";
        $operative_site_json = (addslashes(json_encode($operative_site)));
        $res[$key]['operative_site'] = $operative_site_json;
    }



    print "<br>azienda: {$nome}";

    print "<br>indirizzo legale: {$legal_site_json}";


    
    print "<br>indirizzo operativo: {$operative_site_json}";


    print "<br>";


}
?>

<br>

<button>
    OK MODIFICA
</button>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function ()
    {
        $("button").click(function ()
        {
            values = {};



            values['indirizzi_aziende'] = <?= json_encode($res) ?>;



            $.post("_update_indirizzi.php",
                    values,
                    function (data, status)
                    {
                        console.log(data);
                    });
        });
    });
</script>