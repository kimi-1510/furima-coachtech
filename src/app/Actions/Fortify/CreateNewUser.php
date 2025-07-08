<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    // ここで「名前, メール, パスワード」のチェックと保存
    public function create(array $input)
    {
        // 1. バリデーションルール
        Validator::make($input, [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string','email', 'max:255', 'unique:users'],
            'password' => ['required' ,'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.confirmed' => 'パスワードと一致しません',
        ])->validate(); //ここでチェックOKでない場合は止まってエラーを返す

        // 2. Userモデルを使ってデータベースに保存
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
