<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // メインのプロフィール画面表示（タブ付き）
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->get('page', 'sell');
        
        // 購入した商品一覧
        $purchases = $user->purchases()->with('product')->latest()->get();
        
        // 出品した商品一覧
        $products = $user->products()->latest()->get();
        
        return view('mypage.index', compact('user', 'page', 'purchases', 'products'));
    }

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
    public function editShipping($item_id)
    {
        $user = Auth::user();
        return view('mypage.shipping.edit', compact('user', 'item_id'));
    }

    // 配送先住所更新
    public function updateShipping(AddressRequest $request, $item_id)
    {
        // セッションに一時的な住所変更を保存（アイテムごと）
        // validated()メソッドの問題を回避して、直接リクエストから値を取得
        $shippingData = [
            'post_code' => $request->input('post_code'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
        ];
        
        session([
            "shipping_address_{$item_id}" => $shippingData
        ]);

        return redirect()->route('products.purchase', $item_id);
    }
}

