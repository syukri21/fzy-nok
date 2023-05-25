<?php

namespace App\Cells;

use CodeIgniter\Session\Session;
use CodeIgniter\View\Cells\Cell;
use Config\Services;

class SidebarCell extends Cell
{

    protected Session $cache;

    public function __construct()
    {
        $this->cache = Services::session();
        $this->getFilteredMenus();
    }

    protected array $menus = [
        'user_management' => [
            'name' => 'User Management',
            'menus' => [
                'user' => [
                    'name' => 'Kelola User',
                    'icon_style' => 'menu-icon mdi mdi-account-multiple',
                    'url' => 'usermanagement/manageuser'
                ],
            ]
        ],
        'master_data' => [
            'name' => 'Master Data',
            'menus' => [
                'master_data' => [
                    'name' => 'Master Data',
                    'icon_style' => 'menu-icon mdi mdi-database',
                    'url' => 'masterdata/managemasterdata'
                ],
                'bill_of_material' => [
                    'name' => 'Bill Of Material',
                    'icon_style' => 'menu-icon mdi  mdi-file-document-box',
                    'url' => 'masterdata/managebom'
                ]
            ],
        ],
        'personal' => [
            'name' => 'Personal',
            'menus' => [
                'change_password' => [
                    'name' => 'Ubah Password',
                    'icon_style' => 'menu-icon mdi mdi-key-variant',
                    'url' => 'changeoassword'
                ],
            ],
        ],
    ];

    protected array $exclude_menus = [];

    /**
     * Get menus that are not in the exclude_menus array.
     *
     * @return array
     */
    public function getFilteredMenus(): array
    {
        $cacheKey = 'filtered_menus';

        if ($this->cache->get($cacheKey) !== null) {
            return $this->cache->get($cacheKey);
        }

        $filteredMenus = [];

        foreach ($this->menus as $menuKey => $menu) {
            if (array_key_exists($menuKey, $this->exclude_menus)) {
                $excludedItems = $this->exclude_menus[$menuKey];
                if (is_array($menu) && array_key_exists('menus', $menu)) {
                    $excludedMenus = $menu['menus'];
                    foreach ($excludedItems as $excludedMenu) {
                        unset($excludedMenus[$excludedMenu]);
                    }
                    if (count($excludedMenus) == 0) {
                        continue;
                    }
                    $menu['menus'] = $excludedMenus;
                }
            }

            $filteredMenus[$menuKey] = $menu;
        }

        $this->cache->set($cacheKey, $filteredMenus); // Cache for 1 hour

        return $filteredMenus;
    }
}
