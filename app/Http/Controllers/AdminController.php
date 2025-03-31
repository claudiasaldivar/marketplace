<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'No tienes permisos de administrador'
            ], 403);
        }

        $products = Product::query();

        if ($request->has('user_id')) {
            $products->where('user_id', $request->user_id);
        }

        return $products->with('user:id,name,email')->paginate(15);
    }
}
