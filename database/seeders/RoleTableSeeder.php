<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Roles::cases() as $role) {
            DB::table('roles')->insert([
                'name' => $role->getValue(),
                'title' => $role->getName(),
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        foreach (Permissions::cases() as $role) {
            DB::table('permissions')->insert([
                'name' => $role->getValue(),
                'title' => $role->getName(),
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
