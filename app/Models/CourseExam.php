<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseExam extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'course_courses_id',
        'question',
        'file',
    ];

    protected $cascadeDeletes = [
        'course_exam_answers',
    ];

    public function course_exam_answers()
    {
        return $this->hasMany(CourseExamAnswer::class, 'exam_course_exams_id');
    }

    public function course_exam_course()
    {
        return $this->belongsTo(Course::class, 'course_courses_id')->withTrashed();
    }
}
