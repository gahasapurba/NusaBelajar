<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionCategory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $cascadeDeletes = [
        'discussion_category_categoried_discussions',
    ];

    public function discussion_category_categoried_discussions()
    {
        return $this->hasMany(Discussion::class, 'category_discussion_categories_id');
    }
}
