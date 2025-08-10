<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // プロフィール画面表示
    public function profile()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    // プロフィール更新
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'post_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building = $request->address;

        if ($request->hasFile('profile_image')) {
            // 古い画像を削除
            if ($user->profile_image) {
                \Storage::disk('public')->delete($user->profile_image);
            }
            
            // 新しい画像を保存
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('mypage.profile')->with('success', 'プロフィールが更新されました。');
    }

    // 配送先住所変更画面表示
    public function editShipping()
    {
        $user = Auth::user();
        return view('mypage.shipping.edit', compact('user'));
    }

    // 配送先住所更新
    public function updateShipping(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'post_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->back()->with('success', '配送先住所が更新されました。');
    }
}

