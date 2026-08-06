<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(10);
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
