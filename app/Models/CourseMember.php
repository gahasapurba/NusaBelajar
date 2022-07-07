<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseMember extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'member_users_id',
        'course_courses_id',
    ];

    public function course_member_registered_member()
    {
        return $this->belongsTo(User::class, 'member_users_id')->withTrashed();
    }

    public function course_member_registered_course()
    {
        return $this->belongsTo(Course::class, 'course_courses_id')->withTrashed();
    }
}
