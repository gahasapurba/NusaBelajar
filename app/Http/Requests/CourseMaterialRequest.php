<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sub_topic_course_sub_topics_id' => 'required',
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'youtube_video_link' => 'string|min:3|url|starts_with:https://youtu.be/',
            'file' => 'file|max:102400',
            'estimated_time' => 'required|integer',
        ];
    }
}
