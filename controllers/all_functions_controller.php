<? include __DIR__ . '/../controllers/general_controller.php'; ?>
<?php

class AllFunctions extends General
{

    function __construct()
    {
        parent::__construct();
    }

    public function elenco_aziende()
    {
        $sql = "SELECT
                    *
                FROM
                    `companies`
                WHERE
                    `visible` = 1
                ORDER BY NAME ASC";

        $res = $this->key_select($this->select($sql), 'id');

        return $res;
    }

    public function elenco_persone()
    {
        $sql = "SELECT
                            *
                        FROM
                            `peoples`
                        WHERE
                            `visible` = 1
                        ORDER BY
                            CONCAT(cognome, nome) ASC";

        $res = $this->key_select($this->select($sql), 'id');

        return $res;
    }

    public function elenco_mansioni()
    {
        $sql = "SELECT
                    *
                FROM
                    `tasks_no_istat`
                ORDER BY `name` ASC";

        $res = $this->key_select($this->select($sql), 'task');

        return $res;
    }

    public function elenco_chiavi_mansioni()
    {
        $sql = "SELECT
                    *
                FROM
                    `tasks_no_istat`
                ORDER BY `name` ASC";

        $res = $this->key_select($this->select($sql), 'name');

        return $res;
    }

    public function cerca_comune($search)
    {
        $search_lower = addslashes(strtolower($search));

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
                    comuni.nome LIKE LOWER('%{$search_lower}%')
                ORDER BY comuni.nome ASC        
                    ";
        $res = $this->select($sql);

        $this->write_file("elenco_comuni", $sql);

        return $res;
    }

}
