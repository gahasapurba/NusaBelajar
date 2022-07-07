<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'mentor_users_id',
        'category_course_categories_id',
        'title',
        'slug',
        'price',
        'description',
        'thumbnail',
        'introduction_youtube_video_link',
        'telegram_group_link',
        'syllabus',
        'file',
        'review',
        'is_accepted',
        'is_rejected',
        'is_featured',
        'enrolled_people',
    ];

    protected $cascadeDeletes = [
        'course_sub_topics',
        'course_exams',
        'course_certificates',
        'course_reviews',
    ];

    public function course_sub_topics()
    {
        return $this->hasMany(CourseSubTopic::class, 'course_courses_id');
    }

    public function course_exams()
    {
        return $this->hasMany(CourseExam::class, 'course_courses_id');
    }

    public function course_certificates()
    {
        return $this->hasMany(CourseCertificate::class, 'course_courses_id');
    }

    public function course_reviews()
    {
        return $this->hasMany(CourseReview::class, 'course_courses_id');
    }

    public function course_creator()
    {
        return $this->belongsTo(User::class, 'mentor_users_id')->withTrashed();
    }

    public function course_category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_course_categories_id')->withTrashed();
    }
}
