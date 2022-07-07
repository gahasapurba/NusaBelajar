<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailBroadcastRequest extends FormRequest
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
            'receiver' => 'required|string',
            'subject' => 'required|string|min:3',
            'title' => 'required|string|min:3',
            'message' => 'required|string|min:10',
            'button_text' => 'required|string|min:2',
            'button_link' => 'required|string|min:3|url',
        ];
    }
}
