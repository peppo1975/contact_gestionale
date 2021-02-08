<?php

print __DIR__;

print "<br><br>";

//print_r( scandir(__DIR__."/../../../bin/mysqldump -uroot -p Sql1186079_2> test.sql"));

$now = date("Y-m-d_H_i_s");

$r = exec(__DIR__."/../../../bin/mysqldump -uroot -p contact_gestionale > ".__DIR__."/db_struct/backup/{$now}.sql");

//$s = exec("rm -rf newEmptyPHP.php");

print_r($r);