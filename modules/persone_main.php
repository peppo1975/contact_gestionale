<? $elenco_persone = $persone->elenco_persone() ?>
<style>
    .dataTables_filter{
        text-align: right;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header" hidden="">
                        <h3 class="card-title">
                            <i class="fas fa-industry mr-1"></i>
                            Elenco
                        </h3>
                        <div class="card-tools">
                            <!--                            
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                    </li>
                                </ul>
                            -->
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table id="list_peoples" class="table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th style="word-wrap: break-word">Cognome</th>
                                    <th style="word-wrap: break-word">Nome</th>
                                    <th style="word-wrap: break-word">Data nascita</th>

                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($elenco_persone as $key => $persona): ?>
                                    <tr>
                                        <td style="word-wrap: break-word"><strong><?= $persona['cognome'] ?></strong></td>
                                        <td style="word-wrap: break-word"><strong><?= $persona['nome'] ?></strong></td>
                                        <td style="word-wrap: break-word"><?= $persone->parse_date($persona['data_nascita']) ?></td>

                                    </tr>
                                <? endforeach; ?>

                            </tbody>

                        </table>
                    </div>
                </div>
                <!-- /.card -->

            </section>

        </div>

    </div>
</section>