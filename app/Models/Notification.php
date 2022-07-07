<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'receiver_users_id',
        'type',
        'title',
        'subtitle',
        'content',
    ];

    public function notification_receiver()
    {
        return $this->belongsTo(User::class, 'receiver_users_id')->withTrashed();
    }
}
