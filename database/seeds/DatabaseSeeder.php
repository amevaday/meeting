<?php

namespace Database\Seeders;
use UsersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ServicesTableSeeder::class,
            ClientsTableSeeder::class,
            AppointmentsTableSeeder::class,
        ]);
    }
}
