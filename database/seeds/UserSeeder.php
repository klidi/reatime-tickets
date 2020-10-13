<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create()->each(function ($user) {
            $user->assignRole('admin');
        });
        factory(App\User::class, 50)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
