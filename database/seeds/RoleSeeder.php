<?php

use Kodeine\Acl\Models\Eloquent\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $roleAdmin = $role->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'manage admin privileges'
        ]);
        $roleAdmin->assignPermission('ticket');

        $role = new Role();
        $roleUser = $role->create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'manage user privileges'
        ]);
        $roleUser->assignPermission(['reservations']);
    }
}
