<?

session_start();


if(isset($_POST['clear_session']))
{
    session_destroy();
    die();
}

foreach ($_POST as $key => $value)
{
    $_SESSION['cad_values'][$key] = $value;
}


print_r($_SESSION);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

