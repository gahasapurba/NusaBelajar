<?php

namespace App\Http\Requests\MentorVerificationRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMentorVerificationRequest extends FormRequest
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
            'profile_summary' => 'required|string|min:10',
            'whatsapp_number' => 'required|integer|digits_between:8,15|starts_with:62',
            'facebook_profile_link' => 'nullable|string|min:3|url|starts_with:https://facebook.com/',
            'instagram_profile_link' => 'nullable|string|min:3|url|starts_with:https://instagram.com/',
            'linkedin_profile_link' => 'nullable|string|min:3|url|starts_with:https://linkedin.com/in/',
            'bank_account_number' => 'required|integer|digits_between:8,18',
            'bank_account_name' => 'required|string|min:3',
            'bank_name' => 'required|string|min:3',
            'review' => 'nullable|string|min:3',
        ];
    }
}
