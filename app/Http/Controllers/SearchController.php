<?php

namespace App\Http\Controllers;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Search published products by name, description or SKU.
     */
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));

        $products = AdminProduct::query()
            ->with(['category', 'images'])
            ->where('status', 'published');

        if ($query !== '') {
            $products->where(function (Builder $builder) use ($query): void {
                $builder->where('name', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            });
        }

        $filters = $this->filters($request);

        $this->applyFilters($products, $filters);

        $sort = (string) $request->query('sort', 'newest');

        if ($sort === 'price_low') {
            $products->orderByRaw('COALESCE(sale_price, regular_price) ASC');
        } elseif ($sort === 'price_high') {
            $products->orderByRaw('COALESCE(sale_price, regular_price) DESC');
        } elseif ($sort === 'rating') {
            $products->orderByDesc(
                \Illuminate\Support\Facades\DB::raw(
                    '(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id AND reviews.status = "approved")'
                )
            );
        } else {
            $products->latest();
        }

        $perPage = min((int) $request->query('per_page', 12), 60);

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
            : [];

        return view('search', [
            'query' => $query,
            'products' => $products->paginate($perPage)->withQueryString(),
            'categories' => AdminCategory::query()->where('status', 'published')->orderBy('name')->get(),
            'filters' => $filters,
            'sort' => $sort,
            'wishlistIds' => $wishlistIds,
        ]);
    }

    /**
     * JSON suggestions used by the header autocomplete.
     */
    public function suggest(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        $products = AdminProduct::query()
            ->with('images')
            ->where('status', 'published')
            ->when($query !== '', function (Builder $builder) use ($query): void {
                $builder->where(function (Builder $inner) use ($query): void {
                    $inner->where('name', 'like', "%{$query}%")
                        ->orWhere('short_description', 'like', "%{$query}%")
                        ->orWhere('sku', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (AdminProduct $product): array => [
                'name' => $product->name,
                'url' => route('product.detail', $product),
                'image' => $product->images->first() ? Storage::disk('public')->url($product->images->first()->image) : null,
                'price' => '$'.number_format($product->currentPrice(), 2),
            ])
            ->all();

        $categories = AdminCategory::query()
            ->where('status', 'published')
            ->when($query !== '', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->take(3)
            ->get()
            ->map(fn (AdminCategory $category): array => [
                'name' => $category->name,
                'url' => url('/category/'.$category->slug),
            ])
            ->all();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Normalise filter inputs from the request.
     *
     * @return array<string, string|int|null>
     */
    private function filters(Request $request): array
    {
        return [
            'category' => (string) $request->query('category', ''),
            'min' => $request->query('min'),
            'max' => $request->query('max'),
            'rating' => (int) (string) $request->query('rating', ''),
            'availability' => (string) $request->query('availability', ''),
        ];
    }

    private function applyFilters(Builder $products, array $filters): void
    {
        if ($filters['category'] !== '') {
            $products->where('category_id', (int) $filters['category']);
        }

        $min = (float) $filters['min'];
        $max = (float) $filters['max'];

        if ($min > 0) {
            $products->whereRaw('COALESCE(sale_price, regular_price) >= ?', [$min]);
        }
        if ($max > 0) {
            $products->whereRaw('COALESCE(sale_price, regular_price) <= ?', [$max]);
        }

        $rating = (int) $filters['rating'];
        if ($rating >= 1 && $rating <= 5) {
            $products->whereRaw(
                '(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id AND reviews.status = ?) >= ?',
                [Review::STATUS_APPROVED, $rating]
            );
        }

        if ($filters['availability'] === 'in_stock') {
            $products->where('stock_status', 'in_stock')->where('quantity', '>', 0);
        } elseif ($filters['availability'] === 'on_sale') {
            $products->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'regular_price');
        }
    }
}





