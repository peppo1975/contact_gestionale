<li class="nav-item">
    <a href="../pages/dati_generali.php" class="nav-link dati_generali_sidebar">
        <i class="nav-icon far fa-image"></i>
        <p>
            DatiGenerali
        </p>
    </a>
</li>




/* ************************************ */
MULTI MENU

<li class="nav-item dati_generali_item">
    <a href="../pages/dati_generali.php" class="nav-link dati_generali_sidebar">
        <i class="nav-icon fas fa-truck-pickup"></i>
        <p>
            Mezzi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="../pages/dati_generali.php?dati_generali_elenco" class="nav-link dati_generali_elenco">
                <i class="far fa-circle nav-icon"></i>
                <p>Elenco</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="../pages/dati_generali.php?dati_generali_xxx" class="nav-link dati_generali_xxx    ">
                <i class="far fa-circle nav-icon"></i>
                <p>Tipologie dati_generali</p>
            </a>
        </li>
    </ul>
</li>








$(".dati_generali_sidebar").addClass("active");


$(".dati_generali_item").addClass('menu-open');


<? if (isset($_GET['dati_generali_xxx'])): ?>
    $(".dati_generali_xxx").addClass("active");
<? endif; ?>