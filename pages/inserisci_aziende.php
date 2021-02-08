<?
include '../controllers/inserisci_aziende_controller.php';
$inserisci_aziende = new InserisciAziende();
$title = "InserisciAziende";
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
                                <h1 class="m-0 text-dark">InserisciAziende</h1>
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
                <? include '../modules/inserisci_aziende_main.php'; ?>
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

            var url_post = "../functions/inserisci_aziende_functions.php";

            $(function ()
            {
                $(".aziende_sidebar").addClass("active");
                $(".inserisci_aziende_sidebar").show('fast');
            });

            $(".dropzone").dropzone({
                url: url_post,
                margin: 20,
                height: 40,
                width: 500,
                text: "Trascina il file xlsx",
                params: {
                    'action': 'save',
                    'upload_excel': true
                },
                success: function (res)
                {
                    // console.log(res);

                    to_send = {};

                    to_send['elenco'] = true;

                    $(".loading").show('fast');

                    $.post(url_post, to_send, function (data)
                    {
                        $(".extra-progress-wrapper").hide('slow');
                        $(".tasti_conferma").show('slow');
                        $(".elenco").html(data);
                        console.log(data);
                        $(".loading").hide('fast');
                    });
                }
            });

        </script>

    </body>
</html>
