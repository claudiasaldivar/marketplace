<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return Auth::user()->products;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0'
        ]);

        $product = auth()->user()->products()->create($validated);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return $product;
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|unique:products,sku,'.$product->id,
            'quantity' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $product->user_id !== $user->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Producto eliminado']);
    }

    public function getSellers(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos de administrador'
            ], 403);
        }
        return User::where('role', 'seller')
            ->select('id', 'name', 'email')
            ->get();
    }
}