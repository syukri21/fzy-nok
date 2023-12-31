<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://github.com/codeigniter4/shield/blob/develop/docs/quickstart.md#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title' => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title' => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'operator' => [
            'title' => 'Operator',
            'description' => 'Site programmers.',
        ],
        'ppic' => [
            'title' => 'PPIC',
            'description' => 'General users of the site. Often customers.',
        ],
        'manager' => [
            'title' => 'Manager',
            'description' => 'Has access to beta-level features.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'users.manage-admin' => 'Can manage other admins',
        'users.create' => 'Can create new non-admin users',
        'users.edit' => 'Can edit existing non-admin users',
        'users.delete' => 'Can delete existing non-admin users',
        'users.read' => 'Can read existing non-admin users',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'users.*',
            'masterdatas.*',
            'bom.*',
            'production_plans.*',
        ],
        'admin' => [
            'users.create',
            'users.edit',
            'users.delete',
            'users.read',
            'masterdatas.*',
            'bom.*',
            'production_plans.*'
        ],
        'operator' => [
            "production_plans.read",
            'bom.read',
        ],
        'ppic' => [
            'production_plans.*',
            'bom.read',
        ],
        'manager' => [
            'production_plans.*',
            'bom.read',
        ],
    ];
}
