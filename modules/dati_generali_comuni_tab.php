
<?
$len_find = strlen($find);

$nome_comune = $comune['nome_comune'];

if ($len_find > 0)
{
    $subst = substr(stristr($comune['nome_comune'], $find), 0, $len_find);
}

//$nome_comune = str_replace($subst, "<b style='background-color: greenyellow'>{$subst}</b>", $comune['nome_comune']);
$nome_comune = str_replace($subst, "<b>{$subst}</b>", $comune['nome_comune']);
?>
<tr class="comune" id_comune="<?= $comune['id_comune'] ?>" >
    <td>
        <?= utf8_encode($nome_comune) ?>
    </td>
    <td><?= $comune['sigla'] ?></td>
    <td>
        <?= $comune['nome_regione'] ?>
    </td>
    <td>
        <?= $comune['altitudine'] ?> m
    </td>
    <td>
        <?= $comune['zona'] ?>
    </td>
</tr>