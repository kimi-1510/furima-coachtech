<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Stripe決済画面への遷移
    public function checkout(Product $product)
    {
        // 商品が売り切れでないかチェック
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'この商品は既に売り切れです。');
        }

        // 自分が出品した商品は購入できない
        if (Auth::check() && $product->user_id === Auth::id()) {
            return redirect()->back()->with('error', '自分が出品した商品は購入できません。');
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [asset('storage/' . $product->image)],
                        ],
                        'unit_amount' => $product->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['product' => $product->id]),
                'cancel_url' => route('products.purchase', $product),
                'metadata' => [
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                ],
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '決済画面の表示に失敗しました。');
        }
    }

    // 決済成功時の処理
    public function success(Request $request, Product $product)
    {
        try {
            // 商品を売り切れ状態に更新
            $product->update(['is_sold' => true]);

            // 購入履歴を作成
            Purchase::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'shipping_address' => Auth::user()->full_address,
                'payment_method' => Purchase::PAYMENT_METHOD_CARD,
                'stripe_payment_intent_id' => $request->get('payment_intent'),
                'status' => Purchase::STATUS_COMPLETED,
            ]);

            return redirect()->route('products.index')->with('success', '商品の購入が完了しました！');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', '購入処理中にエラーが発生しました。');
        }
    }

    // Webhook処理（決済完了の確認用）
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // 購入履歴の更新処理
            $purchase = Purchase::where('stripe_payment_intent_id', $session->payment_intent)->first();
            if ($purchase) {
                $purchase->update(['status' => Purchase::STATUS_COMPLETED]);
            }
        }

        return response('OK', 200);
    }
}
