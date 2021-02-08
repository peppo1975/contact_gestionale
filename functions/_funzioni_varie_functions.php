<? include '../controllers/_funzioni_varie_controller.php'; ?>
<? $_funzioni_varie = new FunzioniVarie(); ?>
<?php

/*
  if(isset($_POST['']))
  {

  }

 */

if (isset($_POST['empty_tables']))
{
    $res = $_funzioni_varie->empty_tables();
    print_r(json_encode($res));
}


if (isset($_POST['backup-db']))
{
    
}