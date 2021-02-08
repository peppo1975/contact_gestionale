<?
include '../controllers/inserisci_persone_controller.php';
$inserisci_persone = new InserisciPersone();
$title = "InserisciPersone";
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
                                <h1 class="m-0 text-dark">InserisciPersone</h1>
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
                <? include '../modules/inserisci_persone_main.php'; ?>
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

            var url_post = "../functions/inserisci_persone_functions.php";

            var elenco_aziende = <?= json_encode($elenco_aziende) ?>;

            var company_id;

            $(function ()
            {
//                $(".inserisci_persone_sidebar").addClass("active");
                $(".persone_sidebar").addClass("active");
                $(".inserisci_persone_sidebar").show('fast');
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


            $(".list_companies").change(function ()
            {
                company_id = $(this).val();
                console.log(company_id);

                if (company_id === '')
                {
                    $(".info_company").hide('fast');
                    $(".dropzone").hide('slow');
                    $(".elenco").html('');
                    $(".tasti_conferma").hide('slow');
                    return;
                }

                $(".info_company").show('fast');
                $(".dropzone").show('fast');

                company_info = elenco_aziende[company_id]

                console.log(company_info);

                for (var i in company_info)
                {
                    if ((i === 'legal_site') || (i === 'operative_site'))
                    {
                        var temp;
                        try
                        {
                            temp = JSON.parse(company_info[i]);
                            //console.log(temp);
                            company_info[i] = join_json(temp);
                            console.log(join_json(temp));
                            console.log(i);
                        }
                        catch (error)
                        {
                            //temp = "not";
                        }


                    }

                    $("." + i).html(company_info[i])
                }

            });


            $(".annulla_inserimento").click(function ()
            {
                to_send = {};

                to_send['annulla_inserimento'] = true;

                $.post(url_post, to_send, function (data)
                {
//                    console.log(data);
                    $(".elenco").html('');
                    $(".tasti_conferma").hide('slow');

                });
            });

            $(".conferma_inserimento").click(function ()
            {
                to_send = {};

                to_send['conferma_inserimento'] = company_id;

                $(".loading").show('fast');

                //alert(company_id); return;

                $.post(url_post, to_send, function (data)
                {
                    console.log(data);
                    $(".elenco").html('');
                    $(".tasti_conferma").hide('slow');
                    $(".loading").hide('fast');

                    const Toast = Swal.fire(
                            'Inserimento OK',
                            '',
                            'success'
                            );

                    setTimeout(function ()
                    {
                        location.reload()
                    }, 2000);

                });
            });

            function join_json(object_array)
            {
                var arr = [];
                for (var i in object_array)
                {
                    arr.push(object_array[i]);
                }

                res = arr.join();

                return res;
            }
        </script>

    </body>
</html>
