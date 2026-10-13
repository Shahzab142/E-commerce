<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\ProductQuestion;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductDetailController extends Controller
{
    public function detail(int $id): View
    {
        $product = AdminProduct::with([
            'category',
            'images',
            'approvedReviews',
            ])
            ->where('status', 'published')
            ->findOrFail($id);

        // Track recently viewed products
        $recentlyViewed = session('recently_viewed', []);
        array_unshift($recentlyViewed, $id);
        $recentlyViewed = array_unique($recentlyViewed);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        session(['recently_viewed' => $recentlyViewed]);

        $relatedProducts = AdminProduct::with(['category', 'images'])
            ->where('status', 'published')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();

        $rating = $product->averageRating();
        $reviewsCount = $product->approvedReviews->count();

        // Get Q&A for this product
        $questions = ProductQuestion::with(['user'])
            ->where('product_id', $product->id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        $wishlistIds = auth()->check()
            ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
            : [];

        return view('product-detail', compact('product', 'relatedProducts', 'rating', 'reviewsCount', 'wishlistIds', 'questions'));
    }

    /**
     * Store a product question.
     */
    public function storeQuestion(Request $request, int $id): RedirectResponse
    {
        $product = AdminProduct::where('status', 'published')->findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string|max:500',
        ]);

        ProductQuestion::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'vendor_id' => $product->vendor_id,
            'question' => $validated['question'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your question is sent to admin and please wait for admin reply within 24 hours.');
    }

    /**
     * Quick view API for modal and comparison.
     */
    public function quickView(int $id): \Illuminate\Http\JsonResponse
    {
        $product = AdminProduct::with(['category', 'images'])
            ->where('status', 'published')
            ->findOrFail($id);

        $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'url' => route('product.detail', $product->id),
            'price' => number_format($product->currentPrice(), 2),
            'oldPrice' => $product->sale_price ? number_format($product->regular_price, 2) : null,
            'image' => $image ? \Illuminate\Support\Facades\Storage::disk('public')->url($image->image) : null,
            'rating' => $product->averageRating(),
            'reviewCount' => $product->approvedReviews->count(),
            'category' => $product->category?->name,
            'inStock' => $product->isInStock(),
            'description' => \Illuminate\Support\Str::limit($product->short_description ?: $product->description, 150),
        ]);
    }
}
