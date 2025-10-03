<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Category;

class ProductController extends Controller
{
    public function home()
    {
        return view('guests.home');
    }

    public function index()
    {
        $categories = Category::with('gifts')->get();
        return view('guests.products', compact('categories'));
    }

    public function show($id)
    {
        $gift = Gift::with('addOns')->findOrFail($id);
        return view('guests.product-detail', compact('gift'));
    }

    // Cart Methods
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('guests.cart', compact('cart','total'));
    }

    public function addToCart($id, Request $request)
    {
        $gift = Gift::findOrFail($id);
        $cart = session()->get('cart', []);

        // if item already exists, increment quantity rather than overwrite
        $quantity = intval($request->quantity) > 0 ? intval($request->quantity) : 1;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $gift->name,
                'price' => $gift->price,
                'quantity' => $quantity,
                'image' => $gift->image,
            ];
        }


        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Added to cart!');
    }

    public function updateCart($id, Request $request)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }
}
