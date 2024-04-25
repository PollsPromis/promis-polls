<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class DepartmentsTableSeeder extends Seeder
    {
        public function run()
        {
            DB::table('departments')->insert([
                'title' => 'Отдел сетевых технологий'
            ]);
        }
    }
