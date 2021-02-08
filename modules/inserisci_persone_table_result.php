<? $num_persone = count($elenco) ?>
<? if ($num_persone > 0): ?>
    <?
    $keys = array_keys($elenco['B']);
    ?>
<? else: ?>
    <div style="color: red"><b>DEVI INSERIRE ALMENO UN NOMINATIVO</b></div>
    <? exit; ?>
<? endif; ?>


<div class="row">  
    <div class="col-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Elenco inserimenti (<?= $num_persone ?>)</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">

                    <thead>

                        <tr>
                            <th>indice</th>
                            <? foreach ($keys as $key): ?>
                                <th><?= str_replace("_", " ", $key) ?></th>
                            <? endforeach; ?>

                        </tr>

                    </thead>
                    <tbody>


                        <? foreach ($elenco as $column => $values): ?>

                            <tr>  
                                <td>
                                    <?= $column ?>
                                </td>
                                <? foreach ($values as $key => $value): ?>
                                    <?
                                    if ((substr($key, 0, 5) === "data_") && (strlen($value) > 0))
                                    {
                                        $value = $inserisci_persone->parse_date($inserisci_persone->parse_date_excel_to_timestamp($value));
                                    }
                                    ?>
                                    <td>
                                        <?= $value ?>
                                    </td>

                                <? endforeach; ?>

                            </tr>

                        <? endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>