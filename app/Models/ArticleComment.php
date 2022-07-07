<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleComment extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'article_articles_id',
        'comment',
        'file',
    ];

    public function article_comment_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }

    public function article_comment_commented_article()
    {
        return $this->belongsTo(Article::class, 'article_articles_id')->withTrashed();
    }
}
