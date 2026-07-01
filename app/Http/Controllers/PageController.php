<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    // ======= Public Pages =======
    public function home()
    {
        $room = Room::all();

        return view('web.pages.home', compact('room'));
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

    public function gallery()
    {
        $galleries = Gallery::all();

        return view('web.pages.gallery', compact('galleries'));
    }

    public function blog()
    {
        return view('web.pages.blog');
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

        $contact = new Contact;
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
