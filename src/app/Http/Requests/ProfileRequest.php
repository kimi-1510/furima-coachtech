<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true; // 会員登録済みユーザーはアクセス可能

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            // バリデーションルールを定義
            'name' => 'required|max:20', // 必須、20文字以内
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/', // 必須、郵便番号形式（例: 123-4567）
            'address' => 'required', // 必須
            'building' => 'nullable|string', // 必須ではない
            'image' => 'nullable|image|mimes:png,jpeg,jpg', // 拡張子が.png、.jpeg、.jpg
        ];
    }

    public function messages():array
    {
        return [
            // バリデーションエラーメッセージを定義
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'address.required' => '住所を入力してください',
            'image.image' => '画像を登録してください',
            'image.mimes' => '「.png」「.jpeg」「.jpg」形式でアップロードしてください',
        ];
    }
}
