<?php

namespace App\Http\Controllers;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $topDeals = $this->publishedQuery()
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'regular_price')
            ->latest()
            ->limit(8)
            ->get();

        $latestProducts = $this->publishedQuery()
            ->latest()
            ->limit(8)
            ->get();

        $bestSellers = AdminProduct::query()->withCount([
            'orderItems as sold_count' => fn ($query) => $query->whereHas(
                'order',
                fn ($orderQuery) => $orderQuery->whereNotIn('status', ['cancelled'])
            ),
        ])
            ->where('status', 'published')
            ->orderByDesc('sold_count')
            ->limit(8)
            ->get()
            ->loadMissing('category', 'images', 'approvedReviews');

        $trendingProducts = $this->publishedQuery()
            ->whereHas('approvedReviews')
            ->orderByDesc(
                \Illuminate\Support\Facades\DB::raw(
                    '(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id AND reviews.status = "approved")'
                )
            )
            ->latest()
            ->limit(8)
            ->get();

        $categories = AdminCategory::query()
            ->where('status', 'published')
            ->withCount('products')
            ->orderBy('name')
            ->limit(12)
            ->get();

        $reviews = Review::query()
            ->with(['product.images', 'user'])
            ->where('status', Review::STATUS_APPROVED)
            ->latest()
            ->limit(4)
            ->get();

        $stats = [
            'productCount' => AdminProduct::query()->where('status', 'published')->count(),
            'itemsSold' => (int) OrderItem::query()->whereHas('order', fn ($query) => $query->whereNotIn('status', ['cancelled']))->sum('quantity'),
        ];

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
            : [];

        return view('home', compact(
            'topDeals',
            'latestProducts',
            'bestSellers',
            'trendingProducts',
            'categories',
            'reviews',
            'stats',
            'wishlistIds',
        ));
    }

    /**
     * Shop page — browse all published products, optionally by category.
     */
    public function shop(\Illuminate\Http\Request $request): View
    {
        $categories = AdminCategory::query()
            ->where('status', 'published')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $products = $this->publishedQuery()
            ->when(
                $request->filled('category'),
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('category'))
                )
            )
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where(function ($where) use ($request) {
                    $term = '%' . $request->string('q')->toString() . '%';
                    $where->where('name', 'like', $term)
                        ->orWhere('short_description', 'like', $term);
                })
            )
            ->when(
                $request->filled('min_price'),
                fn ($query) => $query->where(function ($q) use ($request) {
                    $price = (float) $request->input('min_price');
                    $q->where('sale_price', '>=', $price)
                        ->orWhere('regular_price', '>=', $price);
                })
            )
            ->when(
                $request->filled('max_price'),
                fn ($query) => $query->where(function ($q) use ($request) {
                    $price = (float) $request->input('max_price');
                    $q->where('sale_price', '<=', $price)
                        ->orWhere('regular_price', '<=', $price);
                })
            );

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

        $products = $products->paginate(12)->withQueryString();

        $formAction = route('shop');
        $wishlistIds = auth()->check()
            ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
            : [];

        return view('shop', array_merge(compact(
            'categories',
            'products',
            'formAction',
            'wishlistIds',
            'sort'
        ), [
            'minPrice' => (float) $request->input('min_price', 0),
            'maxPrice' => (float) $request->input('max_price', 1000),
        ]));
    }

    private function publishedQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return AdminProduct::query()
            ->with(['category', 'images', 'approvedReviews'])
            ->where('status', 'published');
    }
}