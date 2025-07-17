<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    // 登録フォームを表示
    public function create()
    {
        return view('auth.register');
    }

    // 登録処理
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        // 新しいユーザーをデータベースに保存
        $user = User::Create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        //保存したら自動でログインさせる
        Auth::login($user);

        // 初回登録後はプロフィール設定画面へ遷移
        return redirect('/mypage/profile');
    }
}
