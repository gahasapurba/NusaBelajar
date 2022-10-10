<?php

namespace Database\Seeders;

use App\Models\ArticleComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleComment::create([
            'sender_users_id' => 2,
            'article_articles_id' => 2,
            'comment' => '<p style="text-align:justify;">Anda mau belajar pemrograman, tapi bingung mau belajar bahasa pemrograman yang mana?</p>',
            'file' => 'asdasd',
        ]);
    }
}
