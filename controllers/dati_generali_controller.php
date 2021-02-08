<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php

class DatiGenerali extends AllFunctions
{

    function __construct()
    {
        parent::__construct();
    }

    public function create_tab_list_comuni($array_comuni, $find)
    {
        $res = array();
        $res_tab = "";

        ob_start();
        include __DIR__ . '/../modules/dati_generali_comuni_tab_header.php';
        $head = ob_get_clean();

        foreach ($array_comuni as $key => $comune)
        {
            ob_start();

            include __DIR__ . '/../modules/dati_generali_comuni_tab.php';

            $html = ob_get_clean();

            $res_tab .= $html;
        }

        $res['res_tab'] = $head . "<tbody>" . $res_tab . "</tbody>";
        $res['count_res'] = count($array_comuni);
        $res['array_comuni'] = $array_comuni;
        return $res;
    }

    public function seleziona_comune($id_comune)
    {

        $sql = "SELECT
                        *,
                        comuni.id AS id_comune,
                        comuni.nome AS nome_comune,
                        regioni.nome AS nome_regione
                FROM
                    `comuni`
                INNER JOIN provincie ON comuni.provincia = provincie.id
                INNER JOIN regioni ON provincie.id_regione = regioni.id
                INNER JOIN altitudini_comuni ON altitudini_comuni.comune = comuni.id
                WHERE
                    comuni.id = '{$id_comune}'
                ORDER BY comuni.nome ASC        
                    ";
        $res = $this->select($sql);

//        $this->write_file("seleziona_comune", $sql);
        $this->write_file("selezionato_comune", $res);

        return $res;
    }

}
