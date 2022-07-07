<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleTagged extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $table = 'articles_article_tags';

    protected $fillable = [
        'article_articles_id',
        'tag_article_tags_id',
    ];

    public function article_tagged()
    {
        return $this->belongsTo(Article::class, 'article_articles_id')->withTrashed();
    }

    public function article_tag()
    {
        return $this->belongsTo(ArticleTag::class, 'tag_article_tags_id')->withTrashed();
    }
}
