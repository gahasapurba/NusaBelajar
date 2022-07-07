<?php

namespace Database\Seeders;

use App\Models\ArticleTag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleTag::create([
            'name' => 'Coding',
            'slug' => 'coding',
        ]);
        
        ArticleTag::create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);
        
        ArticleTag::create([
            'name' => 'HTML',
            'slug' => 'html',
        ]);
        
        ArticleTag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);
        
        ArticleTag::create([
            'name' => 'Android',
            'slug' => 'android',
        ]);
        
        ArticleTag::create([
            'name' => 'JavaScript',
            'slug' => 'javascript',
        ]);
        
        ArticleTag::create([
            'name' => 'GitHub',
            'slug' => 'github',
        ]);
        
        ArticleTag::create([
            'name' => 'Website',
            'slug' => 'website',
        ]);
        
        ArticleTag::create([
            'name' => 'Figma',
            'slug' => 'figma',
        ]);
        
        ArticleTag::create([
            'name' => 'Visual Studio Code',
            'slug' => 'visual-studio-code',
        ]);
    }
}
