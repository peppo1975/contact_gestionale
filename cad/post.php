<?
session_start();
$cad_values = $_SESSION['cad_values'];

$file_controvento = sprintf("[%s]", implode(",", $cad_values['segnafile']));

$array_pannelli = array();
foreach ($cad_values['pannelli'] as $pannello)
{
    $array_pannelli[] = sprintf("[%s]", implode(",", $pannello));
}

$pannelli = sprintf("[%s]", implode(",", $array_pannelli));

file_put_contents("pannelli.txt", print_r($pannelli, true));
?>
<? ob_start(); ?>
numero_file = <?= $cad_values['rows'] ?>;
moduli_fila =  <?= $cad_values['columns'] ?>;
altezza_modulo =<?= $cad_values['altezza_modulo'] ?>; //cm
larghezza_modulo = <?= $cad_values['larghezza_modulo'] ?>; //cm
bordo_modulo = 15;
distanza_file = <?= $cad_values['distanza_file'] ?>; //cm

larghezza_zavorra = 15;
altezza_zavorra = altezza_modulo;
larghezza_controvento = 10;

lunghezza_controvento = 300; 

shift_zavorra = 20;


module pannello(x,y){
translate([x,y])
//color("DeepSkyBlue");
difference() {
color("WhiteSmoke")
cube([larghezza_modulo,altezza_modulo,10]);
translate([x+bordo_modulo,y+bordo_modulo,-1])
color("RoyalBlue")
cube([larghezza_modulo - (bordo_modulo*2),altezza_modulo - (bordo_modulo*2),12]);//
};

translate([x+bordo_modulo,y+bordo_modulo])
color("RoyalBlue")
cube([larghezza_modulo - (bordo_modulo*2),altezza_modulo - (bordo_modulo*2),11]);

}



module zavorra(x,y)
{ 
// sul piano x,y

color("Black")
translate([x-larghezza_zavorra/2,y+shift_zavorra,25])
cube([larghezza_zavorra,altezza_zavorra,20]);

color("Black")
translate([x+larghezza_modulo-larghezza_zavorra/2,y+shift_zavorra,25])
cube([larghezza_zavorra,altezza_zavorra,20]);

}


module controvento_verticale ()
{
L = ((altezza_modulo + distanza_file) * numero_file)-distanza_file; //lunghezza totale controvento

GiunzioniVerticali = floor(L/lunghezza_controvento); // per ogni lato

echo("GiunzioniVerticaliGiunzioniVerticali",GiunzioniVerticali);

color("Red")
translate([-larghezza_controvento-larghezza_zavorra/2,shift_zavorra,20])
cube([larghezza_controvento,L,20]);

for(i=[1:GiunzioniVerticali])
{
translate([-2*larghezza_controvento-larghezza_zavorra/2,shift_zavorra-25+(i*lunghezza_controvento),20])
color("Orange")
cube([10,50,50]);



translate([larghezza_controvento+(larghezza_modulo*moduli_fila)+larghezza_zavorra/2, shift_zavorra-25+(i*lunghezza_controvento), 20])
color("Orange")
cube([10,50,50]);
}


color("Red")
translate([(larghezza_modulo*moduli_fila)+larghezza_zavorra/2,shift_zavorra,20])
cube([larghezza_controvento,L,20]);
}


module controvento_orizzontale (file_controvento)                             
{
L = ((larghezza_modulo * moduli_fila) + larghezza_zavorra + (2*larghezza_controvento)); //lunghezza totale controvento sull'asse x

GiunzioniOrizzontali = floor(L/lunghezza_controvento); // per ogni lato

echo("GiunzioniOrizzontali",GiunzioniOrizzontali);

for(file = file_controvento)
{
color("Red")
translate([-larghezza_zavorra/2-larghezza_controvento,(file*(altezza_modulo+distanza_file))-distanza_file+shift_zavorra,20])
cube([L,larghezza_controvento,20]);

for(i=[1:GiunzioniOrizzontali])
{
color("Orange")
translate([-larghezza_zavorra/2 + (i*300) - 25, (file*(altezza_modulo+distanza_file))-distanza_file+shift_zavorra + larghezza_controvento,20])
cube([50,10,50]);
}

}
}



module zavorra_aggiuntiva(file_pannelli)
{
for(fila_pannello = file_pannelli)
{
fila = fila_pannello[0];
modulo_pannello = fila_pannello[1];
/*echo("fila",fila*2);
echo("pannello",pannello);*/
translate([((modulo_pannello-1)*larghezza_modulo)+larghezza_modulo/4,fila*(altezza_modulo + distanza_file)-distanza_file+shift_zavorra+larghezza_controvento])
//cube([larghezza_modulo/2,(distanza_file-shift_zavorra)/2,50]);
cube([larghezza_modulo/2,20,50]);
}
}

// --------------------------------------------------------------------------------------------------------------------------------------------------


for(j=[0:(altezza_modulo + distanza_file):((altezza_modulo + distanza_file) * (numero_file-1))]) //file
{
for(i=[0:larghezza_modulo:(larghezza_modulo*(moduli_fila-1))]) //moduli per fila
{
pannello(i,j);
zavorra(i,j);
}
}

controvento_verticale();

//---------------------------------

//controvento_orizzontale([1,4,5]);
controvento_orizzontale(<?= $file_controvento ?>);

//zavorra_aggiuntiva([[1,1],[1,5],[5,4],[5,2],[4,1],[4,5],[1,3],[4,3]]);
zavorra_aggiuntiva(<?= $pannelli ?>);

//---------------------------------

<? $script = ob_get_clean(); ?>
<? $nome_file = time(); ?>
<? //file_put_contents($nome_file, $script) ?>
<?
$temp = tmpfile();
fwrite($temp, $script);
$path = stream_get_meta_data($temp)['uri'];
//fclose($temp); // this removes the file
?>
<?php
header("Content-type: Application/octet-stream");
header("Content-Disposition: attachment; filename=script.scad");
header("Content-Description: Download PHP");
readfile($path);
?>