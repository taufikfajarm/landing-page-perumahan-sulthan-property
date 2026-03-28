<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign superadmin role to first user if exists and has no roles
        $firstUser = User::first();
        if ($firstUser && $firstUser->roles->isEmpty()) {
            $firstUser->assignRole('superadmin');
        }

        $this->command->info('Roles created: superadmin, admin');
        if ($firstUser) {
            $this->command->info("User '{$firstUser->name}' assigned as superadmin");
        }
    }
}
