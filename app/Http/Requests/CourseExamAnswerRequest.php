<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseExamAnswerRequest extends FormRequest
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
            'exam_course_exams_id' => 'required',
            'answer' => 'required|string|min:10',
            'file' => 'file|max:102400',
            'review' => 'string|min:3',
        ];
    }
}
