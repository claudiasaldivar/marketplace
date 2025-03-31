<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cart = Auth::user()->cart()->with('items.product')->firstOrCreate([]);
        return response()->json($cart);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Auth::user()->cart()->firstOrCreate([]);

        $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => $request->quantity,
                'price' => $product->price
            ]
        );

        return response()->json($cart->load('items.product'), 201);
    }

    public function removeItem($itemId)
    {
        $cart = Auth::user()->cart()->firstOrFail();
        $cart->items()->where('id', $itemId)->delete();

        return response()->json(['message' => 'Item removed']);
    }

    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::where('id', $itemId)
            ->whereHas('cart', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return response()->json($item);
    }
}