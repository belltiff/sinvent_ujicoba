<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori')->insert([
            ['jenis' => 'M', 'kategori' => 'Pendingin Ruang'],
            ['jenis' => 'M', 'kategori' => 'Personal Komputer'],
            ['jenis' => 'M', 'kategori' => 'Laptop'],
            ['jenis' => 'M', 'kategori' => 'Speaker Active'],
            ['jenis' => 'M', 'kategori' => 'Scanner'],
            ['jenis' => 'M', 'kategori' => 'Printer'],
            ['jenis' => 'M', 'kategori' => 'Projector'],
            ['jenis' => 'M', 'kategori' => 'Projector Screen'],
            ['jenis' => 'M', 'kategori' => 'Mesin Bor'],
            ['jenis' => 'A', 'kategori' => 'Crimping Tools'],
            ['jenis' => 'A', 'kategori' => 'Obeng'],
            ['jenis' => 'A', 'kategori' => 'Tang'],
            ['jenis' => 'A', 'kategori' => 'Alat Ukur'],
            ['jenis' => 'A', 'kategori' => 'Solder'],
            ['jenis' => 'BHP', 'kategori' => 'Konektor Jaringan | Bahan Praktik'],
            ['jenis' => 'BHP', 'kategori' => 'Kabel Jumper | Bahan Praktik'],
            ['jenis' => 'BTHP', 'kategori' => 'Perangkat Jaringan | Bahan Praktik'],
            ['jenis' => 'BTHP', 'kategori' => 'Mikrokontroller Board | Bahan Praktik'],
            ['jenis' => 'BTHP', 'kategori' => 'Mikrokontroller Module | Bahan Praktik'],
            ['jenis' => 'BTHP', 'kategori' => 'Komponen Elektronika | Bahan Praktik'],
        ]);
    }
}
