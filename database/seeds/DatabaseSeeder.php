<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            [
                'name' => 'cat',
                'email' => 'cat@mail.com',
                'password'=>bcrypt('12345678'),
            ]
        ]);

        DB::table('books')->insert([
            [
                'name' => 'test',
                'content' => 'test',
                'price'=>99,
                'author_id'=>1
            ],
            [
                'name' => 'helloworld',
                'content' => 'hihi',
                'price'=>22,
                'author_id'=>1
            ],
        ]);

        DB::table('authors')->insert([
            [
                'name' => 'catlookatyou',
            ],
            [
                'name' => 'gogoro',
            ],
        ]);
    }
}
