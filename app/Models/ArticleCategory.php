<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $cascadeDeletes = [
        'article_category_categoried_articles',
    ];

    public function article_category_categoried_articles()
    {
        return $this->hasMany(Article::class, 'category_article_categories_id');
    }
}
