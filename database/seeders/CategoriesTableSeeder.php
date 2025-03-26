<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => '和食', 'description' => '天ぷらや寿司などがある伝統的な和食屋'],
            ['name' => '洋食', 'description' => 'イタリアンレストラン、フランス料理などの洋食屋'],
            ['name' => '魚介・海鮮料理', 'description' => '海鮮丼や刺身などがある料理屋'],
            ['name' => 'パスタ', 'description' => 'パスタ専門の料理屋'],
            ['name' => 'ピザ', 'description' => 'ピザ専門の料理屋'],
            ['name' => '手羽先', 'description' => '手羽先のある料理屋'],
            ['name' => 'カレー', 'description' => 'インドカレー料理屋'],
            ['name' => '韓国料理', 'description' => 'プルコギやチゲ鍋などがある韓国料理屋'],
            ['name' => '中華料理', 'description' => 'ラーメンやチャーハンなどがある中華料理屋'],
            ['name' => '焼肉', 'description' => '焼肉専門の料理屋'],
            ['name' => 'カフェ', 'description' => 'スイーツや軽食などがある料理屋'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
