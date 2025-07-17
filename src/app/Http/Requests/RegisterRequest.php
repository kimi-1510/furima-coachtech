<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true; // 認証は不要なのでtrueを返す
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
            'email' => 'required|email', // 必須、メールアドレス形式
            'password' => 'required|min:8', // 必須、8文字以上
            'password_confirmation' => 'required|min:8|same:password', // 必須、8文字以上、パスワードと一致
        ];
    }

    public function messages(): array
    {
        return [
            // バリデーションエラーメッセージを定義
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password_confirmation.required' => 'パスワードを入力してください',
            'password_confirmation.same' => 'パスワードと一致しません',
        ];
    }
}
