<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            //json形式がどうかのバリデーション
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    // バリデーションの名前
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tag' => 'タグ',
        ];
    }

    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            // sliceはタグの要素数を制限する
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
