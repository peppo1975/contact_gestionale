<?
include __DIR__ . '/../controllers/general_controller.php';

$general = new General();

$file = "";
$class = "";

if (isset($_POST) && count($_POST))
{


    $_SESSION['_construct_pages']['file'] = $_POST['file'];

    $_SESSION['_construct_pages']['class'] = $_POST['class'];

    print_r($_POST);
}


if (isset($_SESSION['_construct_pages']))
{
    $file = $_SESSION['_construct_pages']['file'];
    $class = $_SESSION['_construct_pages']['class'];
}

if (isset($_POST['sposta']))
{
    $general->create_dir("../pages");
    copy("result/{$file}.php", "../pages/{$file}.php");
    unlink("result/{$file}.php");

    $general->create_dir("../controllers");
    copy("result/{$file}_controller.php", "../controllers/{$file}_controller.php");
    unlink("result/{$file}_controller.php");

    $general->create_dir("../functions");
    copy("result/{$file}_functions.php", "../functions/{$file}_functions.php");
    unlink("result/{$file}_functions.php");

    $general->create_dir("../modules");
    copy("result/{$file}_main.php", "../modules/{$file}_main.php");
    unlink("result/{$file}_main.php");

    unset($_POST['sposta']);
}



if (isset($_POST['genera']))
{



    $page = file_get_contents("_page.php");
    $page = str_replace('%%file%%', $file, $page);
    $page = str_replace('%%class%%', $class, $page);
    file_put_contents("result/{$file}.php", $page);

    $controller = file_get_contents("_controller.php");
    $controller = str_replace('%%file%%', $file, $controller);
    $controller = str_replace('%%class%%', $class, $controller);
    file_put_contents("result/{$file}_controller.php", $controller);

    $function = file_get_contents("_functions.php");
    $function = str_replace('%%file%%', $file, $function);
    $function = str_replace('%%class%%', $class, $function);
    file_put_contents("result/{$file}_functions.php", $function);

    $main = file_get_contents("_main.php");
    $main = str_replace('%%file%%', $file, $main);
    $main = str_replace('%%class%%', $class, $main);
    file_put_contents("result/{$file}_main.php", $main);

    $menu = file_get_contents("_menu.php");
    $menu = str_replace('%%file%%', $file, $menu);
    $menu = str_replace('%%class%%', $class, $menu);
    file_put_contents("result/{$file}_menu.php", $menu);

    unset($_POST['genera']);

    print "{$file} OK<br>{$class} OK";

    file_put_contents("result/_last.txt", "file: {$file}\nclass: {$class}");
}




/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<html>
    <body>

        <h2>HTML Forms</h2>

        <form action="index.php" method="POST">
            <label for="fname">file:</label><br>
            <input type="text" id="" name="file" value="<?= $file ?>"><br>
            <label for="lname">class:</label><br>
            <input type="text" id="" name="class" value="<?= $class ?>"><br><br>
            <input type="submit" name="sposta" value="sposta">
            <input type="submit" name="genera" value="genera">
        </form> 

        <p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

    </body>
</html>