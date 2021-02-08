<li class="nav-item">
    <a href="../pages/%%file%%.php" class="nav-link %%file%%_sidebar">
        <i class="nav-icon far fa-image"></i>
        <p>
            %%class%%
        </p>
    </a>
</li>




/* ************************************ */
MULTI MENU

<li class="nav-item %%file%%_item">
    <a href="../pages/%%file%%.php" class="nav-link %%file%%_sidebar">
        <i class="nav-icon fas fa-truck-pickup"></i>
        <p>
            Mezzi
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="../pages/%%file%%.php?%%file%%_elenco" class="nav-link %%file%%_elenco">
                <i class="far fa-circle nav-icon"></i>
                <p>Elenco</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="../pages/%%file%%.php?%%file%%_xxx" class="nav-link %%file%%_xxx    ">
                <i class="far fa-circle nav-icon"></i>
                <p>Tipologie %%file%%</p>
            </a>
        </li>
    </ul>
</li>








$(".%%file%%_sidebar").addClass("active");


$(".%%file%%_item").addClass('menu-open');


<? if (isset($_GET['%%file%%_xxx'])): ?>
    $(".%%file%%_xxx").addClass("active");
<? endif; ?>