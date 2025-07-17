<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true; // 必要に応じて認可
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
            'email' => 'required|email', // 必須、メールアドレス形式
            'password' => 'required|min:8', // 必須、8文字以上
        ];
    }

    public function message()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ];
    } 
}
