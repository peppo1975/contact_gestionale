<? include '../controllers/comuni_controller.php'; ?>
<? $comuni = new Comuni(); ?>
<?php
/*
if(isset($_POST['']))
{
    
}
 
 */
//$name_file = "__regioni_provincie.xlsx";

//$comuni->read_regioni_comuni($name_file);




$name_file = "__comuni_.xlsx";
//
//
$comuni->read_comuni($name_file);
