<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール編集画面を表示するメソッド
    public function profile()
    {
        // 認証済みユーザーの情報を取得
        $user = Auth::user();

        // プロフィール編集画面を表示
        return view('mypage.profile', compact('user'));
    }
    // プロフィール更新処理
    public function update(ProfileRequest $request)
    {
        $data = $request->validated(); // バリデーション済データを取得
        $user = Auth::user(); // ログイン中のユーザー取得

        // 画像がアップロードされたら保存＆古い画像を削除
        if ($request->hasFile('image')) {
            // storage/app/public/profile_images に保存
            $path = $request->file('image')->store('profile_images', 'public');

            // 古い画像があれば削除
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $data['profile_image'] = $path;
        }
        /** @var \App\Models\User $user */
        $user->update($data); // ユーザ情報を更新

        // 更新完了メッセージ付きで戻す
        return redirect()
            ->route('mypage.profile')
            ->with('success', 'プロフィールを更新しました！');
    }
}

