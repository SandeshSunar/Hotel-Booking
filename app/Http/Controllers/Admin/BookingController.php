<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Admin bookings
use App\Models\Book;    // User bookings
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show all bookings
    public function index()
    {
        // 1️⃣ Admin bookings
        $adminBookings = Booking::with(['user', 'room'])->get()->map(function ($b) {
            return (object)[
                'id' => $b->id,
                'user' => $b->user ?? (object)['name' => 'N/A'],
                'room' => $b->room,
                'check_in' => $b->check_in_date,
                'check_out' => $b->check_out_date,
                'status' => $b->status ?? 'pending',
            ];
        });

        // 2️⃣ User bookings
        $userBookings = Book::with('room')->get()->map(function ($b) {
            return (object)[
                'id' => $b->id,
                'user' => (object)['name' => $b->guest_name],
                'room' => $b->room,
                'check_in' => $b->check_in,
                'check_out' => $b->check_out,
                'status' => $b->status ?? 'pending',
            ];
        });

        // 3️⃣ Combine both collections
        $allBookings = $adminBookings->concat($userBookings);

        return view('admin.pages.booking.index', [
            'bookings' => $allBookings
        ]);
    }

    // Show create booking form
    public function create()
    {
        $users = User::all();
        $rooms = Room::where('status', 'available')->get();
        return view('admin.pages.booking.create', compact('users', 'rooms'));
    }

    // Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'required|string',
        ]);

        Booking::create($request->all());

        // Update room status
        Room::where('id', $request->room_id)->update(['status' => 'booked']);

        return redirect()->route('admin.booking.index')->with('success', 'Booking created successfully.');
    }

    // Show edit form
    public function edit(Booking $booking)
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.pages.booking.edit', compact('booking', 'users', 'rooms'));
    }

    // Update booking
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'required|string',
        ]);

        $booking->update($request->all());

        return redirect()->route('admin.booking.index')->with('success', 'Booking updated successfully.');
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        Room::where('id', $booking->room_id)->update(['status' => 'available']);
        $booking->delete();

        return redirect()->route('admin.booking.index')->with('success', 'Booking deleted successfully.');
    }public function approve($id)
    {
        // Try finding Booking (admin)
        $booking = \App\Models\Booking::find($id);

        // If not found, try Book (user)
        if (!$booking) {
            $booking = \App\Models\Book::find($id);
        }

        if ($booking) {
            $booking->status = 'confirmed';
            $booking->save();
            return redirect()->back()->with('success', 'Booking approved successfully!');
        }

        return redirect()->back()->with('error', 'Booking not found.');
    }

    public function reject($id)
    {
        $booking = \App\Models\Booking::find($id);

        if (!$booking) {
            $booking = \App\Models\Book::find($id);
        }

        if ($booking) {
            $booking->status = 'cancelled';
            $booking->save();
            return redirect()->back()->with('success', 'Booking rejected successfully!');
        }

        return redirect()->back()->with('error', 'Booking not found.');
    }


}
