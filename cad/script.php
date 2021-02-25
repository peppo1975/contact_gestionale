<? ob_start(); ?>
<? file_put_contents("post.txt", print_r($_POST, true)) ?>
<script>
    
    let c = document.getElementById("myCanvas");
    let ctx = c.getContext("2d");
    let coordinateZavorre = [];
    let zavorreSelezionate = [];

    let segnaFila = [];
    let segnaFilaSelezionati = [];


<? //$lines = $_POST['values']['rows']                  ?>
<? $lines = $_POST['rows'] ?>
<? //$columns = 5                  ?>
<? $columns = $_POST['columns'] ?>
<? $witdh_p = 70 ?>
<? // $witdh_p = $_POST['larghezza_modulo'];                ?>
<? $heigth_p = 45 ?>
<? // $heigth_p = $_POST['altezza_modulo'];                ?>

<? $d_orizzontal = 10; ?>
<? $d_vertical = 70; ?>
<? $distanza_colonne = 10; ?>
<? $distanza_file = 30; ?>
<? $witdh_z = $witdh_p / 4 ?>
<? $heigth_z = $distanza_file / 3 ?>

<? $segna_fila = 50; ?>
<? $altezza_segnafila = 10; ?>
<? $larghezza_segnafila = 50; ?>



<? for ($line = 0; $line < $lines; $line++): ?>
    <? for ($column = 0; $column < $columns; $column++): ?>

            ctx.fillStyle = 'green';
            ctx.strokeRect(<?= $d_orizzontal + $witdh_z ?> + (<?= $column * ($d_orizzontal + $witdh_p) ?>), <?= $d_vertical - $heigth_z ?> + (<?= $line * ($heigth_p + $distanza_file) ?>), <?= $witdh_p / 2 ?>, <?= $heigth_z ?>);
            coordinateZavorre.push([<?= $d_orizzontal + $witdh_z ?> + (<?= $column * ($d_orizzontal + $witdh_p) ?>), <?= $d_vertical - $heigth_z ?> + (<?= $line * ($heigth_p + $distanza_file) ?>), <?= $witdh_p / 2 ?>, <?= $heigth_z ?>])
            zavorreSelezionate.push(false);

            ctx.fillStyle = 'blue';
            ctx.fillRect(<?= $d_orizzontal ?> + (<?= $column * ($distanza_colonne + $witdh_p) ?>), <?= $d_vertical ?> + (<?= $line * ($distanza_file + $heigth_p) ?>), <?= $witdh_p ?>, <?= $heigth_p ?>)


    <? endfor; ?>

        ctx.fillStyle = 'red';
        ctx.strokeRect(<?= $d_orizzontal + $segna_fila ?> + (<?= $column * ($distanza_colonne + $witdh_p) ?>), <?= $d_vertical ?> + (<?= $line * ($distanza_file + $heigth_p) ?>), <?= $larghezza_segnafila ?>, <?= $altezza_segnafila ?>)
        segnaFila.push([<?= $d_orizzontal + $segna_fila ?> + (<?= $column * ($distanza_colonne + $witdh_p) ?>), <?= $d_vertical ?> + (<?= $line * ($distanza_file + $heigth_p) ?>), <?= $larghezza_segnafila ?>, <?= $altezza_segnafila ?>]);
        segnaFilaSelezionati.push(false);
<? endfor; ?>

    function getMousePosition(canvas, event)
    {
        $("#create_cad").show('fast');

        let rect = canvas.getBoundingClientRect();
        let x = event.clientX - rect.left;
        let y = event.clientY - rect.top;
        console.log("Coordinate x: " + x,
                "Coordinate y: " + y);

        //console.log(coordinateZavorre);

        coordinateZavorre.map((value, index) => {

            let send = false;

            if (x >= value[0] && x <= (value[0] + value[2]) && y >= value[1] && y <= (value[1] + value[3]))
            {
                ctx.fillStyle = 'green';
                ctx.clearRect(...value);
                if (!zavorreSelezionate[index])
                {
                    send = true;
                    ctx.fillRect(...value);
                    zavorreSelezionate[index] = true;
                }
                else
                {
                    send = true;
                    ctx.strokeRect(...value);
                    zavorreSelezionate[index] = false;
                }

                //console.log("ZAVORRE SELEZIONATE", zavorreSelezionate);
                //ctx.fill();

                if (send)
                {
                    let values = [];
                    let rows = <?= $lines ?>;
                    let columns = <?= $columns ?>;
                    zavorreSelezionate.slice(0).reverse().map((value, index) => {
//                    zavorreSelezionate.map((value, index) => {
                        if (value)
                        {
                            row_column = [];

                            row = Math.floor(index / columns) + 1;
                            column = columns - (index % columns);

                            row_column.push(row);
                            row_column.push(column);

                            values.push(row_column);

//                            console.log(index);
//                            console.log("riga", row);
//                            console.log("colonna", column);
//                            //  console.log(index+1);
                        }
                    });


                    //console.log(values);
                    $.post("session.php", {pannelli: values}, (data) => {
                        console.log(data);
                    });
                }
            }
        });


        segnaFila.map((value, index) => {

            let send = false;

            if (x >= value[0] && x <= (value[0] + value[2]) && y >= value[1] && y <= (value[1] + value[3]))
            {
                ctx.fillStyle = 'red';
                ctx.clearRect(...value);
                if (!segnaFilaSelezionati[index])
                {
                    send = true;
                    ctx.fillRect(...value);
                    segnaFilaSelezionati[index] = true;
                }
                else
                {
                    send = true;
                    ctx.strokeRect(...value);
                    segnaFilaSelezionati[index] = false;
                }

                console.log("FILE SELEZIONATE", segnaFilaSelezionati);
                //ctx.fill();

            }
            if (send)
            {
                let values = [];
                segnaFilaSelezionati.slice(0).reverse().map((value, index) => {
                    if (value)
                    {
                        values.push(index + 1);
                    }
                })

                $.post("session.php", {segnafile: values}, (data) => {
                    console.log(data);
                })
            }


        })


    }

    let canvasElem = document.querySelector("canvas");

    canvasElem.addEventListener("mousedown", function (e)
    {
        getMousePosition(canvasElem, e);

    });




</script>
<? $html = ob_get_clean(); ?>
<? print $html; ?>