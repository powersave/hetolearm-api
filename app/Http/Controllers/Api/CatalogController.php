<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'collection', 'variants', 'images'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('collection')) {
            $query->whereHas('collection', fn($q) => $q->where('slug', $request->collection));
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->boolean('new')) {
            $query->where('is_new', true);
        }

        return response()->json([
            'data' => $query->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'collection', 'variants', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json(['data' => $product]);
    }

    public function categories()
    {
        return response()->json([
            'data' => Category::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function collections()
    {
        return response()->json([
            'data' => Collection::where('is_active', true)->orderByDesc('released_at')->get(),
        ]);
    }
}
