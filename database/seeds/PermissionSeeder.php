<?php

use Kodeine\Acl\Models\Eloquent\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $permission = new Permission();
        $permission->create([
            'name'        => 'ticket',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
            ],
            'description' => 'manage tickets'
        ]);

        $permission = new Permission();
        $permission->create([
            'name'        => 'reservations',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => false,
                'delete'     => false,
            ],
            'description' => 'view reservations'
        ]);
    }
}
