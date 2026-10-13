<?php

namespace App\Http\Controllers;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function detail(Request $request, string $slug): View|RedirectResponse
    {
        $category = AdminCategory::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return $this->renderListing($request, $category);
    }

    /**
     * Shared rendering between the top-level category page and the legacy
     * /category/electronics/{slug} route.
     */
    protected function renderListing(Request $request, AdminCategory $category): View|RedirectResponse
    {
        $sort = (string) $request->query('sort', 'newest');

        $query = AdminProduct::with(['category', 'images', 'approvedReviews'])
            ->where('category_id', $category->id)
            ->where('status', 'published');

        $filters = [
            'min' => $request->query('min'),
            'max' => $request->query('max'),
            'rating' => (int) (string) $request->query('rating', ''),
            'availability' => (string) $request->query('availability', ''),
        ];

        $this->applyFilters($query, $filters);

        if ($sort === 'price_low') {
            $query->orderByRaw('COALESCE(sale_price, regular_price) ASC');
        } elseif ($sort === 'price_high') {
            $query->orderByRaw('COALESCE(sale_price, regular_price) DESC');
        } elseif ($sort === 'rating') {
            $query->orderByDesc(
                DB::raw(
                    '(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id AND reviews.status = "approved")'
                )
            );
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        $vendors = collect();

        $priceBounds = AdminProduct::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->selectRaw('COALESCE(MIN(COALESCE(sale_price, regular_price)),0) as min_price')
            ->selectRaw('COALESCE(MAX(COALESCE(sale_price, regular_price)),0) as max_price')
            ->first();

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
            : [];

        return view('category', compact('category', 'products', 'sort', 'filters', 'vendors', 'priceBounds', 'wishlistIds'));
    }

    protected function applyFilters(Builder $query, array $filters): void
    {
        $min = (float) $filters['min'];
        $max = (float) $filters['max'];

        if ($min > 0) {
            $query->whereRaw('COALESCE(sale_price, regular_price) >= ?', [$min]);
        }
        if ($max > 0) {
            $query->whereRaw('COALESCE(sale_price, regular_price) <= ?', [$max]);
        }

        $rating = (int) $filters['rating'];
        if ($rating >= 1 && $rating <= 5) {
            $query->whereRaw(
                '(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id AND reviews.status = "approved") >= ?',
                [$rating]
            );
        }

        if ($filters['availability'] === 'in_stock') {
            $query->where('stock_status', 'in_stock')->where('quantity', '>', 0);
        } elseif ($filters['availability'] === 'on_sale') {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'regular_price');
        }
    }
}