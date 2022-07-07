<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $cascadeDeletes = [
        'event_category_categoried_events',
    ];

    public function event_category_categoried_events()
    {
        return $this->hasMany(Event::class, 'category_event_categories_id');
    }
}
