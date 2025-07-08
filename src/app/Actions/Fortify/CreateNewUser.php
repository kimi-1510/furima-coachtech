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
            'password' => ['required' ,'string', 'min:8'],
            'password_confirmation' => ['required' ,'string', 'min:8', 'same:password'],
        ])->validate(); //ここでチェックOKでない場合は止まってエラーを返す

        // 2. Userモデルを使ってデータベースに保存
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
