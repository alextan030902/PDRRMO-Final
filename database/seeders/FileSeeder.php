<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = ['Memo', 'Executive Order', 'Resolution', 'Advisory'];

        foreach ($categories as $category) {
            for ($i = 0; $i < 10; $i++) {
                DB::table('files')->insert([
                    'name' => $faker->word(),
                    'path' => $faker->filePath(),
                    'extension' => $faker->fileExtension(),
                    'size' => $faker->numberBetween(100, 10000),
                    'category' => $category,
                    'date' => $faker->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
