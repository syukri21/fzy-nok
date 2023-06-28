<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-dashboard <?php echo service('uri')->getSegment(1) === '' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url('/'); ?>">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <?php $filteredMenus = $this->getFilteredMenus();
        foreach ($filteredMenus as $categoryMenus): ?>
            <li class="nav-item nav-category"><?php echo $categoryMenus['name'] ?></li>
            <?php foreach ($categoryMenus['menus'] as $menus): ?>
                <li class="nav-item <?php echo service('request')->uri->getPath() === $menus['url'] ? 'active' : ''; ?>"
                    data-menus="<?= $menus['url'] ?>">
                    <a class="nav-link" href="<?php echo base_url() . $menus['url'] ?>"
                       aria-expanded="false" aria-controls="ui-basic">
                        <i class="<?php echo $menus['icon_style'] ?>"></i>
                        <span class="menu-title"><?php echo $menus['name'] ?></span>
                    </a>
                </li>
            <?php endforeach ?>
        <?php endforeach ?>
    </ul>
</nav>
