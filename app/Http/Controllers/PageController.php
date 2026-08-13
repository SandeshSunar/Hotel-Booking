<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Blog;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Gallery;
use App\Models\Staff;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        $featuredRooms = RoomType::with(['images', 'reviews' => function($q) {
            $q->where('is_approved', true);
        }])
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $averageRating = \App\Models\Review::where('is_approved', true)->avg('rating') ?? 5.0;
        $totalReviews = \App\Models\Review::where('is_approved', true)->count();
        $latestReviews = \App\Models\Review::with('roomType')->where('is_approved', true)->latest()->take(3)->get();
        $allReviews = \App\Models\Review::with('roomType')->where('is_approved', true)->latest()->get();

        // Rating distribution for stats
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = \App\Models\Review::where('is_approved', true)->where('rating', $i)->count();
        }

        return view('web.pages.home', compact('featuredRooms', 'averageRating', 'totalReviews', 'latestReviews', 'allReviews', 'ratingDistribution'));
    }

    public function roomDetails($slug)
    {
        $roomType = RoomType::with(['images', 'facilities', 'reviews' => function($q) {
            $q->where('is_approved', true)->latest();
        }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('web.pages.room_details', compact('roomType'));
    }

    public function submitReview(Request $request, $slug)
    {
        $roomType = RoomType::where('slug', $slug)->firstOrFail();

        // Note: Authentication and booking checks have been bypassed to allow anyone to review.

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $roomType->reviews()->create([
            'name' => auth()->check() ? auth()->user()->name : 'Guest',
            'email' => auth()->check() ? auth()->user()->email : null,
            'rating' => $request->rating,
            'comment' => 'Rating only',
            'is_approved' => false,
        ]);

        return redirect()->back()->with('review_success', 'Your review has been submitted and is waiting for approval.');
    }

    public function about()
    {
        return view('web.pages.about');
    }

    public function rooms()
    {
        $sectionCategories = ['single', 'double', 'family'];

        $allRooms = RoomType::with(['images', 'facilities'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $roomSections = collect($sectionCategories)->mapWithKeys(function ($category) use ($allRooms) {
            return [$category => $allRooms->where('category', $category)->values()];
        });

        return view('web.pages.rooms', compact('roomSections', 'sectionCategories'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('web.pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Your personal details have been updated.');
    }

    public function gallery()
    {
        $galleries = Gallery::all();
        return view('web.pages.gallery', compact('galleries'));
    }

    public function blog()
    {
        $posts = Blog::latest()->get();
        return view('web.pages.blog', compact('posts'));
    }

    public function blogDetails($slug)
    {
        $post = Blog::where('slug', $slug)->firstOrFail();

        $relatedPosts = Blog::where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('web.pages.blog_details', compact('post', 'relatedPosts'));
    }

    // ===== Contact Form Pages =====
    public function showContactForm()
    {
        return view('web.pages.contact');
    }

    public function submitContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'Full name is required.',
            'phone.required' => 'Contact number is required.',
            'message.required' => 'Message is required.',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->save();

        // Optional: send email to admin
        // Mail::to('admin@gmail.com')->send(new \App\Mail\ContactMessage($contact));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    // ======= Auth Pages =======
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    // ======= Admin Dashboard Pages =======
    public function dashboard()
    {
        return view('admin.dashboard.index');
    }

    public function booking()
    {
        $bookings = Booking::with(['guest', 'room'])->get();
        return view('admin.pages.booking', compact('bookings'));
    }

    public function room()
    {
        $rooms = Room::all();
        return view('admin.pages.room', compact('rooms'));
    }

    public function guest()
    {
        $guests = Guest::all();
        return view('admin.pages.guest', compact('guests'));
    }

    public function staff()
    {
        $staff = Staff::all();
        return view('admin.pages.staff', compact('staff'));
    }
}