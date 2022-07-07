<?php

namespace App\Http\Requests\EventRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'category_event_categories_id' => 'required',
            'title' => 'required|string|min:3',
            'location' => 'required|string|min:3',
            'google_map_link' => 'nullable|string|min:3|url|starts_with:https://www.google.com/maps/embed?pb=',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'description' => 'required|string|min:10',
            'thumbnail' => 'image|max:10240',
            'file' => 'file|max:102400',
            'review' => 'nullable|string|min:3',
        ];
    }
}
