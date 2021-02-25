<!doctype html>
<html lang="en">
    <? include '../components/head.php'; ?>
    <body class="py-4">

        <main>
            <div class="container">

                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Numero file</label>
                            <input type="text" id="rows" class="form-control  form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Numero file">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pannelli per fila</label>
                            <input type="text" id="columns"  class="form-control  form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Pannelli per fila">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Distanza file: cm</label>
                            <input type="text" id="distanza_file" class="form-control  form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Distanza file: cm">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Larghezza modulo: cm</label>
                            <input type="text"  id="larghezza_modulo" class="form-control  form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Larghezza modulo: cm">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Altezza modulo: cm</label>
                            <input type="text" id="altezza_modulo" class="form-control  form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Altezza modulo: cm">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">

                            <button type="submit"  id="send_values" class="btn btn-primary mb-2">Visualizza</button>
                            <button type="submit"  id="create_cad" style="display: none" class="btn btn-primary mb-2">CREA CAD</button>
                        </div>
                    </div>
                    <canvas id="myCanvas" width="2000" height="2000"></canvas>
                </div>



















        </main>

        <? include '../components/js.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>

            $(document).ready(function ()
            {
                let values = {};

                $("#send_values").click(() => {
                    values['rows'] = $("#rows").val();
                    values['columns'] = $("#columns").val();
                    values['larghezza_modulo'] = $("#larghezza_modulo").val();
                    values['altezza_modulo'] = $("#altezza_modulo").val();
                    values['distanza_file'] = $("#distanza_file").val();
                    $.post("script.php", values, (data) => {
                        //console.log(data);
                        $("#script").html("");
                        $("#script").html(data);

                    });


                    $.post("session.php", {clear_session: true}, (data) => {
                        console.log(data);
                    });

                });


                $("#create_cad").click(() => {
                    $.post("session.php", values, (data) => {
                        console.log(data);
                        console.log(segnaFilaSelezionati);
                        window.open('post.php', '_blank');
                    })
                })

            });

        </script>
        <div id="script">

        </div>

    </body>
</html>

