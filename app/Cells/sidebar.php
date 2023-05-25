<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <?php foreach ($this->getFilteredMenus() as $categoryMenus): ?>
            <li class="nav-item nav-category"><?= $categoryMenus['name'] ?></li>
            <?php foreach ($categoryMenus['menus'] as $menus): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="<?= $menus['icon_style'] ?>"></i>
                        <span class="menu-title"><?= $menus['name'] ?></span>
                    </a>
                </li>
            <?php endforeach ?>
        <?php endforeach ?>
    </ul>
</nav>