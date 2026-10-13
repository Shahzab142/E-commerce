<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product.
     */
    public function store(Request $request, AdminProduct $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
        ]);

        $product->reviews()->create([
            'user_id' => Auth::id(), // Will be null if guest
            'name'    => $request->name,
            'email'   => $request->email,
            'rating'  => $request->rating,
            'comment' => $request->comment,
            'status'  => Review::STATUS_PENDING,
        ]);

        return back()->with('success', 'Your review has been submitted and is pending approval.');
    }

    /**
     * Reply to a review (typically for admins/vendors).
     */
    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'reply'      => $request->reply,
            'replied_by' => Auth::id(),
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply added successfully.');
    }
}
