<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionAnswer extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'discussion_discussions_id',
        'answer',
        'file',
    ];

    public function discussion_answer_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }

    public function discussion_answer_answered_discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_discussions_id')->withTrashed();
    }
}
