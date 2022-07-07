<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'category_discussion_categories_id',
        'title',
        'slug',
        'description',
        'file',
        'review',
        'is_accepted',
        'is_rejected',
        'is_featured',
    ];

    protected $cascadeDeletes = [
        'discussion_answers',
    ];

    public function discussion_answers()
    {
        return $this->hasMany(DiscussionAnswer::class, 'discussion_discussions_id');
    }

    public function discussion_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }

    public function discussion_category()
    {
        return $this->belongsTo(DiscussionCategory::class, 'category_discussion_categories_id')->withTrashed();
    }
}
