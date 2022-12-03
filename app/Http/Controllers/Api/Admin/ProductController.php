<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        if ($user->roles === 'admin') {
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $product,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        if ($user->roles === 'admin') {
            $product = Product::findOrFail($id);

            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $product,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->roles === 'admin') {
            $product = Product::findOrFail($id);

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'product deleted',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }
}
