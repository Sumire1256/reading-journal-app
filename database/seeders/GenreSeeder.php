<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = ['小説', 'ビジネス', '技術書', '歴史', 'SF', '自己啓発', 'エッセイ'];

        foreach ($genres as $name) {
            Genre::firstOrCreate(['name' => $name]);
        }
    }
}
