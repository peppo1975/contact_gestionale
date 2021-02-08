<?
include '../controllers/_funzioni_varie_controller.php';
$_funzioni_varie = new FunzioniVarie();
$title = "FunzioniVarie";
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
                                <h1 class="m-0 text-dark">FunzioniVarie</h1>
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
                <? include '../modules/_funzioni_varie_main.php'; ?>
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

            var url_post = "../functions/_funzioni_varie_functions.php";

            $(function ()
            {
                $("._funzioni_varie_sidebar").addClass("active");

            });

            $(".empty-tables").click(function ()
            {
                to_send = {};

                to_send['empty_tables'] = true;


                $.post(url_post, to_send, function (data)
                {
                    console.log(data);

                    res = JSON.parse(data);
                    $(".result-empty").html('');
                    for (query in res)
                    {
                        var result = "";

                        if (res[query])
                        {
                            result = '<b style="color: green">OK</b>';
                        }
                        else
                        {
                            result = '<b style="color: red">KO</b>';
                        }
                        query = result + " " + query;
                        $(".result-empty").append(query + '<br>')
                    }
                });
            });

            $(".backup-db").click(() =>
            {
                to_send['backup-db'];
                $.post(url_post, to_send, (data) =>
                {

                });


            });


        </script>

    </body>
</html>
