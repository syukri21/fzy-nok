<?php

namespace App\Cells;

use CodeIgniter\Session\Session;
use CodeIgniter\View\Cells\Cell;
use Config\Services;

class SidebarCell extends Cell
{
    protected Session $cache;

    protected array $menus = [];

    protected array $superadminMenus = [
        'user_management' => [
            'name' => 'User Management',
            'menus' => [
                'user' => [
                    'name' => 'Kelola User',
                    'icon_style' => 'menu-icon mdi mdi-account-multiple',
                    'url' => 'usermanagement/manageuser',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
            ]
        ],
        'master_data' => [
            'name' => 'Master Data',
            'menus' => [
                'master_data' => [
                    'name' => 'Master Data',
                    'icon_style' => 'menu-icon mdi mdi-database',
                    'url' => 'masterdata/managemasterdata',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
                'bill_of_material' => [
                    'name' => 'Bill Of Material',
                    'icon_style' => 'menu-icon mdi  mdi-file-document-box',
                    'url' => 'masterdata/managebom',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ]
            ],
        ],
        'personal' => [
            'name' => 'Personal',
            'menus' => [
                'change_password' => [
                    'name' => 'Ubah Password',
                    'icon_style' => 'menu-icon mdi mdi-key-variant',
                    'url' => 'changepassword',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
            ],
        ],
    ];

    protected array $ppicMenus = [
        'production' => [
            'name' => 'Produksi',
            'menus' => [
                'plan' => [
                    'name' => 'Rencana Produksi',
                    'icon_style' => 'menu-icon mdi mdi-file-check',
                    'url' => 'production/plan',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
                'running' => [
                    'name' => 'Produksi ',
                    'icon_style' => 'menu-icon mdi mdi-wrench',
                    'url' => 'production/running',
                    'actions' => ['read', 'update', 'delete'],
                ],
                'result' => [
                    'name' => 'Hasil Produksi',
                    'icon_style' => 'menu-icon mdi  mdi-chart-areaspline',
                    'url' => 'production/result',
                    'actions' => ['read'],
                ]
            ],
        ],
        'personal' => [
            'name' => 'Personal',
            'menus' => [
                'change_password' => [
                    'name' => 'Ubah Password',
                    'icon_style' => 'menu-icon mdi mdi-key-variant',
                    'url' => 'changepassword',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
            ],
        ],
    ];

    protected array $managerMenus = [
        'production' => [
            'name' => 'Produksi',
            'menus' => [
                'plan' => [
                    'name' => 'Rencana Produksi',
                    'icon_style' => 'menu-icon mdi mdi-file-check',
                    'url' => 'production/plan',
                    'actions' => ['read'],
                ],
                'running' => [
                    'name' => 'Produksi ',
                    'icon_style' => 'menu-icon mdi mdi-wrench',
                    'url' => 'production/running',
                    'actions' => ['read', 'start', 'finish'],
                ],
                'result' => [
                    'name' => 'Hasil Produksi',
                    'icon_style' => 'menu-icon mdi  mdi-chart-areaspline',
                    'url' => 'production/result',
                    'actions' => ['read', 'accept'],
                ]
            ],
        ],
        'personal' => [
            'name' => 'Personal',
            'menus' => [
                'change_password' => [
                    'name' => 'Ubah Password',
                    'icon_style' => 'menu-icon mdi mdi-key-variant',
                    'url' => 'changepassword',
                    'actions' => ['read', 'create', 'update', 'delete'],
                ],
            ],
        ],
    ];

    protected array $operatorMenus = [
        'production' => [
            'name' => 'Produksi',
            'menus' => [
                'running' => [
                    'name' => 'Produksi ',
                    'icon_style' => 'menu-icon mdi mdi-wrench',
                    'url' => 'production/running',
                    'actions' => ['read']
                ],
                'result' => [
                    'name' => 'Hasil Produksi',
                    'icon_style' => 'menu-icon mdi  mdi-chart-areaspline',
                    'url' => 'production/result',
                    'actions' => ['read', 'create', 'update', 'delete']
                ]
            ],
        ],
        'personal' => [
            'name' => 'Personal',
            'menus' => [
                'change_password' => [
                    'name' => 'Ubah Password',
                    'icon_style' => 'menu-icon mdi mdi-key-variant',
                    'url' => 'changepassword'
                ],
            ],
        ],
    ];

    public function __construct()
    {
        $this->cache = Services::session();
    }

    /**
     * @return void
     */
    public function setupMenus()
    {
        $user = auth()->getUser();
        $groups = $user->getGroups();
        if (in_array('manager', $groups)) {
            $this->menus = $this->managerMenus;
        } elseif (in_array('ppic', $groups)) {
            $this->menus = $this->ppicMenus;
        } elseif (in_array('superadmin', $groups)) {
            $this->menus = $this->superadminMenus;
        } else {
            $this->menus = $this->operatorMenus;
        }
    }

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

        $this->setupMenus();;
        $filteredMenus = $this->menus;
        $this->cache->set($cacheKey, $filteredMenus); // Cache for 1 hour

        return $filteredMenus;
    }
}
