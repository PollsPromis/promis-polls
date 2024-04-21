<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class TypesTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table('types')->insert([
                'title' => 'Производство'
            ]);
        }
    }
