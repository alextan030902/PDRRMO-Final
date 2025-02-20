<?php

namespace Database\Seeders;

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
        DB::table('external_files')->insert([
            [
                'title' => 'Sample File 1',
                'description' => 'Description for sample file 1.',
                'file_path' => 'uploads/files/sample1.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 2',
                'description' => 'Description for sample file 2.',
                'file_path' => 'uploads/files/sample2.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 3',
                'description' => 'Description for sample file 3.',
                'file_path' => 'uploads/files/sample3.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 4',
                'description' => 'Description for sample file 4.',
                'file_path' => 'uploads/files/sample4.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 5',
                'description' => 'Description for sample file 5.',
                'file_path' => 'uploads/files/sample5.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 6',
                'description' => 'Description for sample file 6.',
                'file_path' => 'uploads/files/sample6.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 7',
                'description' => 'Description for sample file 7.',
                'file_path' => 'uploads/files/sample7.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 8',
                'description' => 'Description for sample file 8.',
                'file_path' => 'uploads/files/sample8.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 9',
                'description' => 'Description for sample file 9.',
                'file_path' => 'uploads/files/sample9.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 10',
                'description' => 'Description for sample file 10.',
                'file_path' => 'uploads/files/sample10.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 11',
                'description' => 'Description for sample file 11.',
                'file_path' => 'uploads/files/sample11.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 12',
                'description' => 'Description for sample file 12.',
                'file_path' => 'uploads/files/sample12.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 13',
                'description' => 'Description for sample file 13.',
                'file_path' => 'uploads/files/sample13.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 14',
                'description' => 'Description for sample file 14.',
                'file_path' => 'uploads/files/sample14.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 15',
                'description' => 'Description for sample file 15.',
                'file_path' => 'uploads/files/sample15.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 16',
                'description' => 'Description for sample file 16.',
                'file_path' => 'uploads/files/sample16.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 17',
                'description' => 'Description for sample file 17.',
                'file_path' => 'uploads/files/sample17.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 18',
                'description' => 'Description for sample file 18.',
                'file_path' => 'uploads/files/sample18.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 19',
                'description' => 'Description for sample file 19.',
                'file_path' => 'uploads/files/sample19.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sample File 20',
                'description' => 'Description for sample file 20.',
                'file_path' => 'uploads/files/sample20.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
