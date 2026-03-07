<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nip' => '18200001'],
            [
                'name' => 'Admin Sistem',
                'email' => 'faridmuhammad7472@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $pegawai = [
            ['nip' => '18220001', 'name' => 'Pegawai Satu'],
            ['nip' => '18220002', 'name' => 'Pegawai Dua'],
        ];

        foreach ($pegawai as $p) {
            User::updateOrCreate(
                ['nip' => $p['nip']],
                [
                    'name' => $p['name'],
                    'email' => null,
                    'password' => Hash::make('pegawai123'),
                    'role' => 'pegawai',
                ]
            );
        }
    }
}
