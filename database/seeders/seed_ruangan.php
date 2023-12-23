<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class seed_ruangan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for( $i = 0; $i < 10; $i++ ) {
            Ruangan::create(["nama" => "ruangan $i"]);
        }
    }
}
