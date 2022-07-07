<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseMaterial extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'sub_topic_course_sub_topics_id',
        'title',
        'slug',
        'description',
        'video_link',
        'file',
        'estimated_time',
    ];

    public function course_material_course_sub_topic()
    {
        return $this->belongsTo(CourseSubTopic::class, 'sub_topic_course_sub_topics_id')->withTrashed();
    }
}
