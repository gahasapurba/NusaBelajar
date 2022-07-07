<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseReview extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'course_courses_id',
        'review',
        'file',
    ];

    public function course_review_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }

    public function course_review_reviewed_course()
    {
        return $this->belongsTo(Course::class, 'course_courses_id')->withTrashed();
    }
}
