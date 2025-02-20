<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Iloilo locations categorized by district
        $districts = [
            '1st District' => ['Igbaras Iloilo', 'Guimbal Iloilo', 'Miag-ao Iloilo', 'Oton Iloilo', 'Tigbauan Iloilo', 'Tubungan Iloilo', 'San Joaquin Iloilo'],
            '2nd District' => ['Alimodian Iloilo', 'Leganes Iloilo', 'Leon Iloilo', 'New Lucena Iloilo', 'Pavia Iloilo', 'San Miguel Iloilo', 'Sta. Barbara Iloilo', 'Zarraga Iloilo'],
            '3rd District' => ['Badiangan Iloilo', 'Bingawan Iloilo', 'Cabatuan Iloilo', 'Calinog Iloilo', 'Janiuay Iloilo', 'Lambunao Iloilo', 'Maasin Iloilo', 'Mina Iloilo', 'Pototan Iloilo'],
            '4th District' => ['Anilao Iloilo', 'Banate Iloilo', 'Barotac Nuevo Iloilo', 'Dingle Iloilo', 'Duenas Iloilo', 'Dumangas Iloilo', 'Passi Iloilo', 'San Enrique Iloilo'],
            '5th District' => ['Ajuy Iloilo', 'Balasan Iloilo', 'Barotac Viejo Iloilo', 'Batad Iloilo', 'Carles Iloilo', 'Concepcion Iloilo', 'Estancia Iloilo', 'Lemery Iloilo', 'San Dionisio Iloilo', 'San Rafael Iloilo', 'Sara Iloilo'],
        ];

        // Categories to choose from
        $categories = ['MDRRMO', 'HOSPITALS', 'IPPO', 'BFP'];

        // Create 42 sample contacts
        foreach (range(1, 42) as $index) {
            // Select a random district and corresponding municipality
            $district = array_rand($districts);
            $municipality = $faker->randomElement($districts[$district]);

            // Select a random category
            $category = $faker->randomElement($categories);

            // Clean up the phone number to be purely numeric
            $phone_number = preg_replace('/\D/', '', $faker->phoneNumber);

            DB::table('contacts')->insert([
                'category' => $category,
                'district' => $district,
                'municipality' => $municipality,
                'focal_person' => $faker->name,
                'contact_number' => $phone_number,
                'email' => $faker->email,
                'response_team' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
