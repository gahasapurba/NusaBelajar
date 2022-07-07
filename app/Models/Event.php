<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'organizer_users_id',
        'category_event_categories_id',
        'title',
        'slug',
        'location',
        'google_map_link',
        'start_datetime',
        'end_datetime',
        'description',
        'thumbnail',
        'file',
        'review',
        'is_accepted',
        'is_rejected',
        'registered_people',
    ];
    
    protected $dates = [
        'start_datetime',
        'end_datetime',
    ];

    public function event_creator()
    {
        return $this->belongsTo(User::class, 'organizer_users_id')->withTrashed();
    }

    public function event_category()
    {
        return $this->belongsTo(EventCategory::class, 'category_event_categories_id')->withTrashed();
    }
}
