<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCertificate extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'receiver_users_id',
        'course_courses_id',
        'certificate_id',
    ];

    public function course_certificate_receiver()
    {
        return $this->belongsTo(User::class, 'receiver_users_id')->withTrashed();
    }

    public function course_certificate_course()
    {
        return $this->belongsTo(Course::class, 'course_courses_id')->withTrashed();
    }
}
