<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoFormRequest extends FormRequest
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

    public function rules()
    {
        return [
            'title' => ['bail','required','max:64'],
            'content' => ['bail','required','max:255']
        ];
    }

    public function messages()
    {
        return[
            'title.required'=>':attributeは必須です。',
            'title.max'=>':attributeは64文字以下で入力してください。',
            'content.required'=>':attributeは必須です。',
            'title.max'=>':attributeは255文字以下で入力してください。',
        ];
    }

    public function attributes()
    {
        return[
            'title' => 'タイトル',
            'content' => 'メモ',
        ];
    }
}
