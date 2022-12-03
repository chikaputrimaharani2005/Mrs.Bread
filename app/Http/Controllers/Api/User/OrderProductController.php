<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function store(Product $product, Request $request)
    {
        $user = auth()->user();

        if ($user->roles === 'user') {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'transaction_code' => 'TRX' . mt_rand(10000, 99999),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'quantity' => $request->quantity,
                'total_price' => $product->price * $request->quantity,
                'status' => 'PENDING',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }
}
