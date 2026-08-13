<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('roomType');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
        }

        $reviews = $query->latest()->paginate(10)->appends($request->all());
        return view('admin.pages.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        return view('admin.pages.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        return redirect()->route('admin.reviews.index')->with('success', 'Review status updated successfully.');
    }
}
