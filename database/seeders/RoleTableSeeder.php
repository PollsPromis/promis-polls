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
/*
 * $table->bigIncrements('id');
                $table->string('first_name');
                $table->string('second_name');
                $table->string('email')->unique();
                $table->string('login')->unique();
                $table->string('password');
                $table->unsignedBigInteger('role_id');
                $table->timestamps();

                $table->foreign('role_id')->references('id')->on('roles');
 */
