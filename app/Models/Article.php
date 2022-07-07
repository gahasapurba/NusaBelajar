<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'author_users_id',
        'category_article_categories_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'file',
        'quote',
        'review',
        'is_accepted',
        'is_rejected',
        'is_featured',
        'view',
    ];

    protected $cascadeDeletes = [
        'article_comments',
    ];

    public function article_comments()
    {
        return $this->hasMany(ArticleComment::class, 'article_articles_id');
    }

    public function article_creator()
    {
        return $this->belongsTo(User::class, 'author_users_id')->withTrashed();
    }

    public function article_category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_article_categories_id')->withTrashed();
    }

    public function article_tags()
    {
        return $this->belongsToMany(ArticleTag::class, 'articles_article_tags', 'article_articles_id', 'tag_article_tags_id')->withTrashed();
    }
}
