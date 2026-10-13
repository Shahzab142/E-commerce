<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReviewController extends Controller
{
    /**
     * List all reviews with an optional status filter.
     */
    public function index(Request $request): View
    {
        $reviews = Review::query()
            ->with(['product', 'user'])
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', $request->query('status'))
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', Review::STATUS_PENDING)->count(),
            'approved' => Review::where('status', Review::STATUS_APPROVED)->count(),
            'rejected' => Review::where('status', Review::STATUS_REJECTED)->count(),
        ];

        return view('admin.reviews', compact('reviews', 'stats'));
    }

    /**
     * Approve, reject or reset a review's moderation status.
     */
    public function updateStatus(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:' . Review::STATUS_APPROVED . ',' . Review::STATUS_REJECTED . ',' . Review::STATUS_PENDING,
            ],
        ]);

        $review->update(['status' => $validated['status']]);

        $message = match ($validated['status']) {
            Review::STATUS_APPROVED => 'Review approved and is now visible on the product.',
            Review::STATUS_REJECTED => 'Review rejected.',
            default => 'Review moved back to pending.',
        };

        return back()->with('success', $message);
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
