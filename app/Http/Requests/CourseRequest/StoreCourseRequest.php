<?php

namespace App\Http\Requests\CourseRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'category_course_categories_id' => 'required',
            'title' => 'required|string|min:3|unique:courses',
            'price' => 'required|integer|min:1000',
            'description' => 'required|string|min:10',
            'thumbnail' => 'required|image|max:10240',
            'introduction_youtube_video_link' => 'required|string|min:3|url|unique:courses|starts_with:https://youtu.be/',
            'telegram_group_link' => 'required|string|min:3|url|unique:courses|starts_with:https://t.me/',
            'syllabus' => 'required|file|max:102400',
            'file' => 'file|max:102400',
            'review' => 'nullable|string|min:3',
        ];
    }
}
