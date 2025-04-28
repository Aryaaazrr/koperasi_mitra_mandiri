<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Anggota\Seeders\AnggotaSeeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Superadmin', 'Admin', 'Anggota'
        ];

        foreach ($data as $value) {
            Role::insert([
                'nama_role' => $value
            ]);
        }

        User::factory()->create([
            'nama'              => 'Superadmin',
            'username'          => 'superadmin',
            'password'          => Hash::make('p4ssword'),
            'id_role'           => 1,
        ]);
        User::factory()->create([
            'nama'              => 'Admin',
            'username'          => 'admin',
            'password'          => Hash::make('p4ssword'),
            'id_role'           => 2,
        ]);

        // $this->call([
        //     AnggotaSeeder::class,
        // ]);
    }
}
