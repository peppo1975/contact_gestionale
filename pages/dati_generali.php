<?
include '../controllers/dati_generali_controller.php';
$dati_generali = new DatiGenerali();
$title = "DatiGenerali";
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
                                <h1 class="m-0 text-dark">DatiGenerali</h1>
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
                <? include '../modules/dati_generali_main.php'; ?>
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

            var url_post = "../functions/dati_generali_functions.php";

            var elements;

            $(function ()
            {
                $(".dati_generali_sidebar").addClass("active");

                $("#nominativo_cliente").keyup((text) => {

                    $("#nominativo_cliente_view").html(sprintf("<b>Cliente:</b> %s", text.currentTarget.value));
                });

                $("#nome_citta").keyup((text) => {
                    let  to_send = {};
                    if (text.currentTarget.value.length >= 2)
                    {
                        to_send['cerca_comune'] = text.currentTarget.value
                        $.post(url_post, to_send, (data) =>
                        {
//                            console.log(data);
                            if (data === "")
                            {
                                data = {};
                                data['count_res'] = 0;
                                data['res_tab'] = "";
                            }
                            $(".elenco_comuni").html(data.res_tab);
                            $("#count_res").html(data.count_res + " risultati");

                            elements = document.getElementsByClassName("comune");

                            function Myf()
                            {

                                let id_comune = this.getAttribute('id_comune');
                                console.log(id_comune);
                                select_comune(id_comune);

                                return true;
                            }

                            for (var i = 0; i < elements.length; i++)
                            {
                                elements[i].addEventListener('click', Myf, false);
                            }
                        });
                    }

                    if (text.currentTarget.value.length == 0)
                    {
                        $(".elenco_comuni").html("");
                        $(".elenco_comuni").html("");
                        $("#count_res").html("");
                    }
                });


            });

            function select_comune(id_comune)
            {
//                for (i in elements)
//                {
//                    if (isNaN(i))
//                        continue;
//
//                    let id_comune_list = elements[i].attributes.id_comune.nodeValue;
//                    console.log(id_comune_list);
//
////                    if (id_comune_list !== id_comune)
////                        elements[i].style.display = "none";
//
//                    if (id_comune_list === id_comune)
//                    {
//                        console.log(elements[i]);
//                    }
//                    elements[i].style.display = "none";
//                }

                $(".elenco_comuni").html("");
                $(".elenco_comuni").html("");
                $("#count_res").html("");

                let to_send = {};

                to_send['seleziona_comune'] = id_comune;

                $.post(url_post, to_send, function (data)
                {
                    console.log(data);
                    $("#nome_citta_view").html(sprintf("<b>Comune:</b> %s, (%s), %s", data[0].nome_comune, data[0].sigla, data[0].nome_regione))
                    $("#quote_view").html(sprintf("<b>Altitudine:</b> %s m, <b>Zona:</b> %s", data[0].altitudine, data[0].zona))
                    $("#codici_view").html(sprintf("<b>cod. com.:</b> %s, <b>cod. prov.:</b> %s, <b>cod. reg.:</b> %s", data[0].cod_com, data[0].cod_prov, data[0].cod_reg))
                });

            }
        </script>

    </body>
</html>
