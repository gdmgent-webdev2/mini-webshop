<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class ShopController extends Controller
{

    public function index(string $slug = null, Cart $cart) {
        $products = null;

        $shoppingCart = $cart->get(Auth::id());

        if (!$slug) {
            $products = Product::all();
        } else {
            $category = Category::where('slug', $slug)->firstOrFail();
            $products = Product::where('category_id', $category->id)->get();
        }

        $categories = Category::all();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'slug' => $slug,
            'cart' => $shoppingCart,
        ]);
    }

    public function addToCart(Request $request, Cart $cart)
    {
        $product = Product::findOrFail($request->product_id);

        $cart->add(Auth::id(), [
            'id' => $product->id,
            'quantity' => 1,
            'name' => $product->name,
            'price' => $product->price,
            'model' => $product,
        ]);

        return redirect()->back();
    }

    public function getOrder(Order $order)
    {
        // warning: no check at the moment if order is created by authenticated user
        return view('shop.order', [
            'order' => $order,
        ]);
    }

    public function order(Cart $cart)
    {
        $shoppingCart = $cart->get(Auth::id());

        if (!$shoppingCart->hasItems()) {
            return redirect()->route('shop');
        }

        // create order
        $order = Order::create();
        // add all products to pivot table
        foreach ($shoppingCart->items as $item) {
            $order->products()->attach($item->id, [
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // clear cart session
        $cart->clear(Auth::id());

        // create Mollie payment
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => strval($shoppingCart->getTotal() / 100),
            ],
            "description" => "Order #" . $order->id,
            "redirectUrl" => route('shop.order', $order->id),
            "webhookUrl" => config('app.url') . route('webhooks.mollie', [], false),
            "metadata" => [
                "order_id" => $order->id,
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook(Request $request) {
        Log::debug('In webhook');
        $paymentId = $request->input('id');
        Log::debug($paymentId);
        $payment = Mollie::api()->payments->get($paymentId);

        $order = Order::findOrFail($payment->metadata->order_id);
        $order->status = $payment->status;
        $order->save();

        return view('shop.index');
    }
}
