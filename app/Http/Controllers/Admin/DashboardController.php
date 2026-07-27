<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\RoomType;
use App\Models\Guest;
use App\Models\Staff;
use App\Models\Gallery;
use App\Models\Contact;

class DashboardController extends Controller
{
    // ---------------- DASHBOARD ----------------
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->usertype !== 'admin') {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $totalBookings = Booking::whereIn('status', ['pending', 'confirmed'])->count();

        $statistics = [
            'totalBookings'   => $totalBookings,
            'totalRooms'      => RoomType::count(),
            'availableRooms'  => RoomType::where('available_rooms', '>', 0)->count(),
            'totalGuests'     => Guest::count(),
            'totalStaff'      => Staff::count(),
        ];

        $recentBookings = Booking::with(['guest', 'roomType'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($b) {
                return (object) [
                    'id' => $b->id,
                    'guest' => $b->guest ?? (object) ['name' => $b->guest_name],
                    'room' => $b->roomType,
                    'check_in' => $b->check_in,
                    'check_out' => $b->check_out,
                    'status' => $b->status,
                ];
            });

        $recentGuests = Guest::latest()->take(5)->get();
        $recentStaff  = Staff::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'statistics', 'recentBookings', 'recentGuests', 'recentStaff'
        ));
    }


    // ---------------- MESSAGES ----------------
    public function message()
    {
        $messages = Contact::latest()->get();
        return view('admin.pages.message.index', compact('messages'));
    }

    public function messageShow(Contact $contact)
    {
        return view('admin.pages.message.show', ['message' => $contact]);
    }

    public function messageEdit(Contact $contact)
    {
        return view('admin.pages.message.edit', ['message' => $contact]);
    }

    public function messageUpdate(Request $request, Contact $contact)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'message' => 'required|string',
        ], [
            'name.required'    => 'Name is required.',
            'phone.required'   => 'Contact number is required.',
            'message.required' => 'Message is required.',
        ]);

        $contact->update($request->only('name', 'phone', 'message'));

        return redirect()->route('admin.message.index')
                         ->with('success', 'Message updated successfully.');
    }

    public function messageDestroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.message.index')
                         ->with('success', 'Message deleted successfully.');
    }

    // Show gallery page
    public function galleryIndex()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.pages.gallery.index', compact('galleries'));
    }

    // Show form to upload new image
    public function galleryCreate()
    {
        return view('admin.pages.gallery.create');
    }

    // Upload/store new image
    public function galleryStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required' => 'Gallery name is required.',
            'image.required' => 'Gallery image is required.',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Image uploaded successfully.');
    }

    // Show form to edit image
    public function galleryEdit(Gallery $gallery)
    {
        return view('admin.pages.gallery.edit', compact('gallery'));
    }

    // Update gallery image
    public function galleryUpdate(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required' => 'Gallery name is required.',
        ]);

        $data = ['title' => $request->title];

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Image updated successfully.');
    }

    // Delete an image
    public function galleryDestroy(Gallery $gallery)
    {
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Image deleted successfully.');
    }
}
