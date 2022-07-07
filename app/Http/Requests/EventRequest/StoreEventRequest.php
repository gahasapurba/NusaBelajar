<?php

namespace App\Http\Requests\EventRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => 'required|string|min:3|unique:events',
            'location' => 'required|string|min:3',
            'google_map_link' => 'nullable|string|min:3|url|starts_with:https://www.google.com/maps/embed?pb=',
            'start_datetime' => 'required|date|after_or_equal:tomorrow',
            'end_datetime' => 'required|date|after:start_datetime',
            'description' => 'required|string|min:10',
            'thumbnail' => 'required|image|max:10240',
            'file' => 'file|max:102400',
            'review' => 'nullable|string|min:3',
        ];
    }
}
