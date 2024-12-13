<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = [
            [
                'nama' => 'John Doe',
                'nim' => '2024001',
                'email' => 'john.doe@university.com',
                'jurusan' => 'Teknik Informatika'
            ],
            [
                'nama' => 'Jane Smith',
                'nim' => '2024002',
                'email' => 'jane.smith@university.com',
                'jurusan' => 'Sistem Informasi'
            ],
            [
                'nama' => 'Bob Johnson',
                'nim' => '2024003',
                'email' => 'bob.johnson@university.com',
                'jurusan' => 'Teknik Komputer'
            ]
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
    }
}
