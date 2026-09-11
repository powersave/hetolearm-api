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
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with('blocks')
            ->firstOrFail();

        return response()->json([
            'id' => $category->id,
            'slug' => $category->slug,
            'name' => $category->name,
            'body_part' => $category->body_part,
            'main_image' => $category->main_image ? '/storage/' . $category->main_image : null,
            'background_image' => $category->background_image ? '/storage/' . $category->background_image : null,
			'background_opacity' => $category->background_opacity ?? 30,
            'content' => $category->content,
            'blocks' => $category->blocks->map(function ($block) {
                return [
                    'id' => $block->id,
                    'title' => $block->title,
                    'description' => $block->description,
                    'image' => $block->image ? '/storage/' . $block->image : null,
                    'sort_order' => $block->sort_order,
                ];
            }),
        ]);
    }

    public function categories()
    {
        return response()->json([
            'data' => Category::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'slug' => $category->slug,
                        'name' => $category->name,
                        'body_part' => $category->body_part,
                        'main_image' => $category->main_image ? '/storage/' . $category->main_image : null,
                        'background_image' => $category->background_image ? '/storage/' . $category->background_image : null,
						'background_opacity' => $category->background_opacity ?? 30,
                        'content' => $category->content,
                        'sort_order' => $category->sort_order,
                    ];
                }),
        ]);
    }

    public function categoryShow(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['blocks' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $category->id,
                'slug' => $category->slug,
                'name' => $category->name,
                'body_part' => $category->body_part,
                'main_image' => $category->main_image ? '/storage/' . $category->main_image : null,
                'background_image' => $category->background_image ? '/storage/' . $category->background_image : null,
				'background_opacity' => $category->background_opacity ?? 30,
                'content' => $category->content,
                'blocks' => $category->blocks->map(function ($block) {
                    return [
                        'id' => $block->id,
                        'title' => $block->title,
                        'description' => $block->description,
                        'image' => $block->image ? '/storage/' . $block->image : null,
                        'sort_order' => $block->sort_order,
                    ];
                }),
            ],
        ]);
    }

    public function collections()
    {
        return response()->json([
            'data' => Collection::where('is_active', true)->orderByDesc('released_at')->get(),
        ]);
    }
}