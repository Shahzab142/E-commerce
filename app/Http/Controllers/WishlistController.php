<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\WishlistItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * Show the authenticated user's wishlist.
     */
    public function index(Request $request): View
    {
        $items = $request->user()
            ->wishlistItems()
            ->with('product.category', 'product.images')
            ->latest()
            ->get();

        return view('wishlist', compact('items'));
    }

    /**
     * Add or remove a product from the wishlist.
     */
    public function toggle(Request $request, AdminProduct $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $item = WishlistItem::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->delete();

            return back()->with('success', 'Product removed from your wishlist.');
        }

        WishlistItem::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Product added to your wishlist.');
    }

    /**
     * Remove a product from the wishlist (used on the wishlist page).
     */
    public function remove(Request $request, AdminProduct $product): RedirectResponse
    {
        WishlistItem::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Removed from your wishlist.');
    }
}