<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php

class Aziende extends AllFunctions
{




    function __construct()
    {
        parent::__construct();
    }


    public function indirizzo_parse($indirizzo_json)
    {
        $indirizzo = json_decode($indirizzo_json,true);
        
        $res = implode(", ", $indirizzo);
        
        return $res;
    }

}
