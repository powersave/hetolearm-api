<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'comment' => 'nullable|string|max:2000',
            'items'   => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            'items.*.size'       => 'required|string|max:20',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
            'locale'  => 'nullable|string|in:ru,en',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total = collect($request->items)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'comment' => $request->comment,
            'items'   => $request->items,
            'total'   => $total,
            'locale'  => $request->locale ?? 'ru',
            'status'  => 'new',
        ]);

        return response()->json(['data' => $order, 'message' => 'Order created'], 201);
    }
}
