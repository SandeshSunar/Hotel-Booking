<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
    private function blogPosts(): array
    {
        return [
            [
                'slug' => 'best-time-to-visit-our-city',
                'title' => 'Best Time to Visit Our City',
                'excerpt' => 'Discover the most enchanting seasons to enjoy your stay and make unforgettable memories.',
                'category' => 'Travel Tips',
                'date' => 'June 12, 2026',
                'read_time' => '4 min read',
                'image' => asset('images/blog1.jpg'),
                'content' => [
                    'Spring and autumn are the sweet spots for comfortable weather, lighter crowds, and the best city views.',
                    'If you enjoy lively streets and seasonal events, summer brings the most energy, while winter offers a calmer, more relaxed stay.',
                ],
                'highlights' => [
                    'Best weather for sightseeing',
                    'Seasonal festivals and events',
                    'Better availability for premium rooms',
                ],
            ],
            [
                'slug' => 'top-5-things-to-do-nearby',
                'title' => 'Top 5 Things to Do Nearby',
                'excerpt' => 'From scenic views to cultural landmarks, explore everything just steps away from our hotel.',
                'category' => 'Local Guide',
                'date' => 'June 14, 2026',
                'read_time' => '3 min read',
                'image' => asset('images/blog2.jpg'),
                'content' => [
                    'Start with the city landmark district, then move on to museums, cafes, and the waterfront promenade.',
                    'Our team can recommend the best routes depending on whether you want family-friendly attractions, nightlife, or a relaxed afternoon walk.',
                ],
                'highlights' => [
                    'Walkable attractions',
                    'Family-friendly stops',
                    'Recommended by our concierge',
                ],
            ],
            [
                'slug' => 'gourmet-dining-experiences',
                'title' => 'Gourmet Dining Experiences',
                'excerpt' => 'Indulge your senses in a world of flavor crafted by our world-class chefs.',
                'category' => 'Dining',
                'date' => 'June 18, 2026',
                'read_time' => '5 min read',
                'image' => asset('images/blog3.jpg'),
                'content' => [
                    'Dining at the hotel is designed to feel both elegant and relaxed, with menus shaped around fresh ingredients and memorable presentation.',
                    'Whether you want a quick breakfast, a long dinner, or an intimate private meal, our culinary team focuses on quality and atmosphere.',
                ],
                'highlights' => [
                    'Seasonal menu selections',
                    'Private dining available',
                    'Chef-inspired signature dishes',
                ],
            ],
            [
                'slug' => 'wellness-and-spa-services',
                'title' => 'Wellness and Spa Services',
                'excerpt' => 'Relax, refresh, and rejuvenate because you deserve to feel your best every day.',
                'category' => 'Wellness',
                'date' => 'June 21, 2026',
                'read_time' => '4 min read',
                'image' => asset('images/blog4.jpg'),
                'content' => [
                    'Our wellness experiences are built around calm, balance, and restoration. Guests can unwind with treatments that help reset both mind and body.',
                    'After a long travel day, spa and wellness time can turn a good stay into a great one.',
                ],
                'highlights' => [
                    'Relaxing treatments',
                    'Peaceful spa atmosphere',
                    'Ideal for recovery and recharge',
                ],
            ],
        ];
    }

    // ======= Public Pages =======
    public function home()
    {
        $featuredRooms = Room::latest()->take(3)->get();

        return view('web.pages.home', compact('featuredRooms'));
    }

    public function roomDetails($id)
    {
        $room = Room::findOrFail($id);
        return view('web.pages.room_details', compact('room'));
    }

    public function about()
    {
        return view('web.pages.about');
    }

    public function rooms()
    {
        $room = Room::all();
        return view('web.pages.rooms', compact('room'));
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
        $posts = collect($this->blogPosts());

        return view('web.pages.blog', compact('posts'));
    }

    public function blogDetails($slug)
    {
        $post = collect($this->blogPosts())->firstWhere('slug', $slug);

        abort_if(! $post, 404);

        $relatedPosts = collect($this->blogPosts())
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values();

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
            'message' => 'required|string',
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