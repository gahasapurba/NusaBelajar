<?php

namespace App\Http\Requests\DiscussionRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscussionRequest extends FormRequest
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
            'category_discussion_categories_id' => 'required',
            'title' => 'required|string|min:3|unique:discussions',
            'description' => 'required|string|min:10',
            'file' => 'file|max:102400',
            'review' => 'nullable|string|min:3',
        ];
    }
}
