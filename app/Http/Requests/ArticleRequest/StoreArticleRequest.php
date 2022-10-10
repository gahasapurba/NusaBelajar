<?php

namespace App\Http\Requests\ArticleRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'category_article_categories_id' => 'required',
            'tag_article_tags_id' => 'required',
            'title' => 'required|string|min:3|unique:articles',
            'content' => 'required|string|min:10',
            'thumbnail' => 'required|image|max:10240',
            'file' => 'file|max:102400',
            'quote' => 'nullable|string|min:3',
            'review' => 'nullable|string|min:10',
        ];
    }
}
