<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleTag extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $cascadeDeletes = [
        'article_tag_tagged_articles',
    ];

    public function article_tag_tagged_articles()
    {
        return $this->belongsToMany(Article::class, 'articles_article_tags', 'tag_article_tags_id', 'article_articles_id')->withTrashed();
    }
}
