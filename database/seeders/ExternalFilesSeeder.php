<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExternalFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generating 10 records as an example
        foreach (range(1, 20) as $index) {
            DB::table('external_files')->insert([
                'title' => 'External Services #'.rand(1, 100).'s.'.rand(1000, 9999),
                'description' => $faker->text(),
                'file_path' => $faker->word().'/'.$faker->word().'.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
