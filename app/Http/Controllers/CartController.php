<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image" => $product->image ?? 'image/default.png'
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    // Удалить товар из корзины
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Товар удалён из корзины');
    }

    // Очистить корзину
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Корзина очищена');
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantity']++;
        }
        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id]) && $cart[$id]['quantity'] > 1){
            $cart[$id]['quantity']--;
        }
        session()->put('cart', $cart);

        return redirect()->back();
    }

// Вспомогательная функция
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

}
