<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ReflectionClass;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Кастет',
            'second_name' => 'зеленый слоник',
            'email' => 'root@test.ru',
            'login' => '1',
            'password' => Hash::make('root'),
        ]);

        $user = User::whereEmail('root@test.ru')->first();
        $user->assignRole('root');

        $role = \Spatie\Permission\Models\Role::where('name', 'root')->first();
        $role->givePermissionTo(
            array_values((new ReflectionClass(Permissions::class))->getConstants())
        );
    }
}
