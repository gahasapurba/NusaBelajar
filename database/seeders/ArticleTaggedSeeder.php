<?php

namespace Database\Seeders;

use App\Models\ArticleTagged;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleTaggedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleTagged::create([
            'article_articles_id' => 1,
            'tag_article_tags_id' => 1,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 1,
            'tag_article_tags_id' => 2,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 1,
            'tag_article_tags_id' => 6,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 1,
            'tag_article_tags_id' => 10,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 2,
            'tag_article_tags_id' => 1,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 2,
            'tag_article_tags_id' => 8,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 2,
            'tag_article_tags_id' => 10,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 2,
            'tag_article_tags_id' => 7,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 2,
            'tag_article_tags_id' => 3,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 3,
            'tag_article_tags_id' => 2,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 3,
            'tag_article_tags_id' => 8,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 3,
            'tag_article_tags_id' => 10,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 3,
            'tag_article_tags_id' => 3,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 4,
            'tag_article_tags_id' => 1,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 4,
            'tag_article_tags_id' => 7,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 4,
            'tag_article_tags_id' => 10,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 4,
            'tag_article_tags_id' => 6,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 4,
            'tag_article_tags_id' => 5,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 5,
            'tag_article_tags_id' => 1,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 5,
            'tag_article_tags_id' => 6,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 5,
            'tag_article_tags_id' => 10,
        ]);
        
        ArticleTagged::create([
            'article_articles_id' => 5,
            'tag_article_tags_id' => 7,
        ]);
    }
}
