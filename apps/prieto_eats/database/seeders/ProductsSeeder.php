<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::insert("INSERT INTO products(id, name, description, price, image, created_at, updated_at) VALUES (1, 'Menu 1', 'Muy rico', 12.30,'storage/img/menu2dic2025.png', '2026-01-01 10:24:15', '2026-01-01 10:24:15')");

        DB::insert("INSERT INTO products(id, name, description, price, image, created_at, updated_at) VALUES (2, 'Pastel de patata', 'Inmejorable', 5.00,'storage/img/pollo.png', '2026-01-12 12:14:19', '2026-01-12 13:04:19')");

        DB::insert("INSERT INTO products(id, name, description, price, image, created_at, updated_at) VALUES (3, 'Pavlova de Frutos Rojos', 'Nose lo que es', 4.00,'storage/img/pollo.png', '2026-01-12 13:06:29', '2026-01-12 13:06:39')");

        DB::insert("INSERT INTO products(id, name, description, price, image, created_at, updated_at) VALUES (4, 'Solomillo de Cerdo Stroganoff', 'Tiene buena pinta', 4.00,'storage/img/pollo.png', '2026-01-12 13:06:39', '2026-01-12 13:06:39')");



    }
}
