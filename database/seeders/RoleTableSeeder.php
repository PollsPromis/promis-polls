<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class RoleTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table('roles')->insert([
                'title' => 'Супер админ'
            ]);
        }
    }
