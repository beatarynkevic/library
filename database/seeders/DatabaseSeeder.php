<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
        ]);

        $faker = Faker::create('lt_LT'); //statinis metodas
        $authors=10;
        $publishers=10;

        foreach(range(1, $authors) as $_) {
            DB::table('authors')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName()
            ]);
        }

        foreach(range(1, $publishers) as $_) {
            DB::table('publishers')->insert([
                'title' => $faker->company(),
            ]);
        }

        foreach(range(1, 100) as $_) {
            DB::table('books')->insert([
                'title' => str_replace(['.', '"', "'", ')', '(' ], '', $faker->realText(rand(10, 30))),
                'isbn' => $faker->isbn13(),
                'pages' => rand(22, 550),
                'about' => $faker->realText(500, 4),
                'author_id' => rand(1, $authors),
                'publisher_id' => rand(1, $publishers),
            ]);
        }

    }
}
