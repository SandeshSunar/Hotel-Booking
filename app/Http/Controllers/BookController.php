<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\RoomType;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'rooms_count' => 'required|integer|min:1',
            'guest_name' => ['required', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'email' => 'required|email|max:255',
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'special_requests' => 'nullable|string|max:1000',
        ], [
            'guest_name.regex' => 'Name must only contain letters.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        $roomType = RoomType::where('is_active', true)
            ->where('status', 'available')
            ->findOrFail($validated['room_type_id']);

        $adults = (int) $validated['adults'];
        $children = (int) ($validated['children'] ?? 0);
        $roomsCount = (int) $validated['rooms_count'];

        if ($adults > $roomType->capacity_adults * $roomsCount) {
            return back()->withInput()->with('error', 'Guest count exceeds room capacity for the selected number of rooms.');
        }

        if ($children > $roomType->capacity_children * $roomsCount) {
            return back()->withInput()->with('error', 'Children count exceeds room capacity for the selected number of rooms.');
        }

        $available = $roomType->availableUnitsForDates($validated['check_in'], $validated['check_out']);

        if ($available < $roomsCount) {
            return back()->withInput()->with('error', 'Not enough rooms available for the selected dates.');
        }

        $nights = max(1, (new \DateTime($validated['check_in']))->diff(new \DateTime($validated['check_out']))->days);
        $totalPrice = $roomType->display_price * $nights * $roomsCount;

        $guest = Guest::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['guest_name'],
                'phone' => $validated['phone'],
                'address' => 'N/A',
            ]
        );

        $booking = Booking::create([
            'room_type_id' => $roomType->id,
            'guest_id' => $guest->id,
            'user_id' => auth()->id(),
            'guest_name' => $validated['guest_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'adults' => $adults,
            'children' => $children,
            'rooms_count' => $roomsCount,
            'special_requests' => $validated['special_requests'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'payment_method' => 'cash',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking submitted successfully! We will confirm your reservation shortly.');
    }
}
