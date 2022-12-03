<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }
}
