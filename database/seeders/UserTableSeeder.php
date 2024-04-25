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
