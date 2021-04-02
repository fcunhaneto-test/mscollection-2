<?php

namespace Database\Seeders;

use App\Models\Qualifiers\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Ação', 'e_name' => 'Action'],
            ['name' => 'Adulto', 'e_name' => 'Adult'],
            ['name' => 'Animação', 'e_name' => 'Animation'],
            ['name' => 'Aventura', 'e_name' => 'Adventure'],
            ['name' => 'Biografia', 'e_name' => 'Biography'],
            ['name' => 'Comédia', 'e_name' => 'Comedy'],
            ['name' => 'Crime', 'e_name' => 'Crime'],
            ['name' => 'Documentário', 'e_name' => 'Documentary'],
            ['name' => 'Drama', 'e_name' => 'Drama'],
            ['name' => 'Esporte', 'e_name' => 'Sport',],
            ['name' => 'Família', 'e_name' => 'Family'],
            ['name' => 'Fantasia', 'e_name' => 'Fantasy'],
            ['name' => 'Faroeste', 'e_name' => 'Western'],
            ['name' => 'Ficção Científica', 'e_name' => 'Sci-Fi'],
            ['name' => 'Film Noir', 'e_name' => 'Film Noir'],
            ['name' => 'Guerra', 'e_name' => 'War'],
            ['name' => 'Histórico', 'e_name' => 'History'],
            ['name' => 'Mistério', 'e_name' => 'Mystery'],
            ['name' => 'Musical', 'e_name' => 'Musical'],
            ['name' => 'Terror', 'e_name' => 'Horror'],
            ['name' => 'Thriller', 'e_name' => 'Thriller']
        ];

        foreach ($categories as $arr) {
            Category::create($arr);
        }
    }
}
