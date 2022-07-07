<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'receiver_users_id',
        'message',
        'file',
    ];

    public function message_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }

    public function message_receiver()
    {
        return $this->belongsTo(User::class, 'receiver_users_id')->withTrashed();
    }
}
