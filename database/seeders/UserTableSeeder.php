<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class UserTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table('users')->insert([
                'first_name' => 'Кастет',
                'second_name' => 'зеленый слоник',
                'email' => '1@test.ru',
                'login' => '1',
                'password' => '1',
                'role_id' => 1
            ]);
        }
    }
