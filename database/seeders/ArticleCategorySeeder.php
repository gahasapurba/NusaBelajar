<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleCategory::create([
            'name' => 'Programming',
            'slug' => 'programming',
        ]);
        
        ArticleCategory::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);
        
        ArticleCategory::create([
            'name' => 'Back End',
            'slug' => 'back-end',
        ]);
        
        ArticleCategory::create([
            'name' => 'Front End',
            'slug' => 'front-end',
        ]);
        
        ArticleCategory::create([
            'name' => 'Data',
            'slug' => 'data',
        ]);
        
        ArticleCategory::create([
            'name' => 'Web',
            'slug' => 'web',
        ]);
        
        ArticleCategory::create([
            'name' => 'Mobile',
            'slug' => 'mobile',
        ]);
        
        ArticleCategory::create([
            'name' => 'Security',
            'slug' => 'security',
        ]);
        
        ArticleCategory::create([
            'name' => 'Network',
            'slug' => 'network',
        ]);
        
        ArticleCategory::create([
            'name' => 'IOT',
            'slug' => 'iot',
        ]);
    }
}
