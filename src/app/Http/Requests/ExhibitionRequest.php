<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // 認証済みユーザーはアクセス可能
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // 商品名：入力必須
            'description' => 'required|string|max:255', // 商品説明：入力必須、最大文字数255
            'image' => 'required|image|mimes:jpeg,jpg,png', // 商品画像：アップロード必須、拡張子が.jpeg、jpgもしくは.png
            'categories' => 'required|array|min:1', // 商品のカテゴリー：選択必須
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い', // 商品の状態：選択必須
            'price' => 'required|integer|min:0', // 商品価格：入力必須、数値型、0円以上
            'brand_name' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です',
            'name.max' => '商品名は255文字以内で入力してください',
            'description.required' => '商品の説明は必須です',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'image.required' => '商品画像を選択してください',
            'image.image' => '選択されたファイルは画像ではありません',
            'image.mimes' => '対応している画像形式は.jpeg、.jpg、.pngです',
            'categories.required' => 'カテゴリは必須です',
            'status.required' => '商品の状態は必須です',
            'price.required' => '販売価格は必須です',
            'price.integer' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
            'brand_name.max' => 'ブランド名は255文字以内で入力してください',
        ];
    }
}
