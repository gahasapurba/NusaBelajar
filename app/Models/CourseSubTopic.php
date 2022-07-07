<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSubTopic extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'course_courses_id',
        'title',
        'slug',
        'description',
        'file',
    ];

    public function course_sub_topic_course()
    {
        return $this->belongsTo(Course::class, 'course_courses_id')->withTrashed();
    }
}
