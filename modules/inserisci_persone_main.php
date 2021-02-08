<?
$elenco_aziende = $inserisci_persone->elenco_aziende();

//print_r($elenco_aziende);
?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-xl-3">
                <div class="row">
                    <div class="col">
                        <label>Azienda</label>
                        <select class="form-control select2 list_companies" style="width: 100%;">
                            <option></option>
                            <? foreach ($elenco_aziende as $key => $azienda): ?>
                                <option value="<?= $key ?>"><?= $azienda['name'] ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="dropzone" style="display: none"></div>
                    </div>
                </div>

            </div>

            <div class="col-xl-1">

            </div>

            <div class="col-xl-2" style="padding-top: 31px;">
                <a class="btn btn-primary" href="../functions/inserisci_persone_functions.php?persone_massive_excel" target="_blank" role="button">
                    Scarica il file excel
                </a>
            </div>

            <div class="col-xl-6">
                <div class="card bg-light info_company" style="display: none">
                    <div class="card-header text-muted border-bottom-0">
                        <!--Digital Strategist-->
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h2 class="lead" ><strong class="lead business_name"></strong></h2>
                                <p class="text-muted text-sm"></p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">

                                    <li class=""><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Sede Legale: <b class="legal_site" ></b></li>
                                    <li class=""><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Sede operativa: <b class="operative_site" ></b></li>
                                    <li class=""><span class="fa-li"><i class="fas fa-lg fa-mobile"></i></span> Cellulare: <b  class="cell_phone"></b></li>
                                    <li class=""><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefono: <b  class="phone"></b></li>
                                </ul>
                            </div>
                            <!--                                                        <div class="col-5 text-center">
                                                                                        <img src="../dist/img/user1-128x128.jpg" alt="" class="img-circle img-fluid">
                                                                                    </div>-->
                        </div>
                    </div>

                </div>
            </div>



        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-xl-4 loading"  style="display: none; text-align: center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-xl tasti_conferma" style="display: none">
                <button type="button" class="btn btn-success conferma_inserimento">CONFERMA INSERIMENTO</button>
                <button type="button" class="btn btn-danger annulla_inserimento">ANNULLA INSERIMENTO</button>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xl elenco">

            </div>
        </div>


    </div>
</section>


