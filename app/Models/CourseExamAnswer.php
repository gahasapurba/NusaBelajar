<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseExamAnswer extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sender_users_id',
        'exam_course_exams_id',
        'answer',
        'file',
        'review',
        'is_accepted',
        'is_rejected',
    ];

    public function course_exam_answer_creator()
    {
        return $this->belongsTo(User::class, 'sender_users_id')->withTrashed();
    }
    
    public function course_exam_answer_answered_course_exam()
    {
        return $this->belongsTo(CourseExam::class, 'exam_course_exams_id')->withTrashed();
    }
}
