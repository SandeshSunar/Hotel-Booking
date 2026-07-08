<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomType;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['roomType', 'guest', 'user', 'payment'])
            ->latest()
            ->get();

        return view('admin.pages.booking.index', compact('bookings'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();

        return view('admin.pages.booking.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'rooms_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        $nights = max(1, (new \DateTime($validated['check_in']))->diff(new \DateTime($validated['check_out']))->days);
        $totalPrice = $roomType->display_price * $nights * (int) $validated['rooms_count'];

        $guest = \App\Models\Guest::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['guest_name'],
                'phone' => $validated['phone'],
                'address' => 'Walk-in',
            ]
        );

        $booking = Booking::create(array_merge($validated, [
            'guest_id' => $guest->id,
            'children' => $validated['children'] ?? 0,
            'total_price' => $totalPrice,
        ]));

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'payment_method' => 'cash',
            'status' => $validated['status'] === 'confirmed' ? 'paid' : 'pending',
        ]);
        
        if ($validated['status'] === 'confirmed') {
            $roomType->update(['status' => 'unavailable']);
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        $roomTypes = RoomType::all();

        return view('admin.pages.booking.edit', compact('booking', 'roomTypes'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'guest_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'rooms_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        $nights = max(1, (new \DateTime($validated['check_in']))->diff(new \DateTime($validated['check_out']))->days);
        $validated['total_price'] = $roomType->display_price * $nights * (int) $validated['rooms_count'];
        $validated['children'] = $validated['children'] ?? 0;

        $guest = \App\Models\Guest::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['guest_name'],
                'phone' => $validated['phone'],
                'address' => 'Walk-in',
            ]
        );
        $validated['guest_id'] = $guest->id;

        $booking->update($validated);

        if ($booking->payment) {
            $booking->payment->update([
                'amount' => $validated['total_price'],
                'status' => $validated['status'] === 'confirmed' ? 'paid' : ($validated['status'] === 'cancelled' ? 'refunded' : 'pending'),
            ]);
        }
        
        if ($validated['status'] === 'confirmed') {
            $roomType->update(['status' => 'unavailable']);
        } elseif ($validated['status'] === 'cancelled') {
            $roomType->update(['status' => 'available']);
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->payment?->delete();
        $booking->delete();

        return redirect()->route('admin.booking.index')->with('success', 'Booking deleted successfully.');
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        if ($booking->payment) {
            $booking->payment->update(['status' => 'paid']);
        }
        
        if ($booking->roomType) {
            $booking->roomType->update(['status' => 'unavailable']);
        }

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        if ($booking->payment) {
            $booking->payment->update(['status' => 'refunded']);
        }
        
        if ($booking->roomType) {
            $booking->roomType->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Booking cancelled successfully!');
    }
}
