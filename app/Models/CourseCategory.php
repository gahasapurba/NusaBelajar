<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $cascadeDeletes = [
        'course_category_categoried_courses',
    ];

    public function course_category_categoried_courses()
    {
        return $this->hasMany(Course::class, 'category_course_categories_id');
    }
}
