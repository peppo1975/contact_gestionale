<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php



class Home extends AllFunctions
{



    function __construct()
    {
        parent::__construct();

    }









    public function numero_persone()
    {
        $sql = "SELECT
                    COUNT(id) AS num_persone
                FROM
                    `peoples`
                WHERE
                    `visible` = 1
                ORDER BY
                    CONCAT(cognome, nome) ASC";

        $res = $this->select($sql);

        return $res;

    }









    public function numero_aziende()
    {
        $sql = "SELECT
                    COUNT(id) AS num_aziende
                FROM
                    `companies`
                WHERE
                    `visible` = 1
                ORDER BY NAME ASC";

        $res = $this->select($sql);

        return $res;

    }









    public function tema_scadenza($num_scadenze, $type)
    {
        $tema = array();

        $tema['day'] = "bg-red";
        $tema['week'] = "bg-orange";
        $tema['month'] = "bg-yellow";
        
//        print_r($tema);

        switch ((int) $num_scadenze)
        {
            case 0:
                $tema[$type] = "bg-green";
                break;
            default :
                break;
        }

        return $tema[$type];

    }









}
