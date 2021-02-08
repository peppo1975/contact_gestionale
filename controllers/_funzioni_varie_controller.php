<? include __DIR__ . '/../controllers/all_functions_controller.php'; ?>
<?php

class FunzioniVarie extends AllFunctions
{




    function __construct()
    {
        parent::__construct();
    }




    public function empty_tables()
    {
        //          TRUNCATE `company_people` 
        //          TRUNCATE `peoples`

        $tables = array();
        
        $tables[] = "TRUNCATE `company_people`";
        
        $tables[] = "TRUNCATE `peoples`";
        
        $res = array();

        foreach ($tables as $sql)
        {
            $res[$sql] = $this->my_query($sql);
        }
        
        return $res;
    }

    public function backup_db()
    {
//        exec("")
    }


}
