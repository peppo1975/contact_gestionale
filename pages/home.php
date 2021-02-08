<?
include '../controllers/home_controller.php';
$home = new Home();
$numero_persone = $home->numero_persone();
$numero_aziende = $home->numero_aziende();

$title = "Home";
?>
<!DOCTYPE html>
<html>

    <? include '../components/head.php'; ?>

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">

            <!-- Navbar -->
            <? include '../components/navbar.php'; ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <? include '../components/sidebar.php'; ?>

            <!-- Content Wrapper. Contains page content -->





            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Home</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <!--<li class="breadcrumb-item active">Dashboard v1</li>-->
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <? include '../modules/home_main.php'; ?>
                <!-- /.content -->
            </div>





            <!-- /.content-wrapper -->

            <? include '../components/footer.php'; ?>

            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <? include '../components/js.php'; ?>

        <script>

            /*
             to_send = {};
             
             $.post(url_post, to_send, function (data)
             {
             console.log(data);
             });
             */

            var url_post = "../functions/home_functions.php";

            $(function ()
            {
                $(".home_sidebar").addClass("active");
            });

     


        </script>

    </body>
</html>
