<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusMail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['roomType', 'guest', 'user', 'payment'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $bookings = $query->get();

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
            'status' => 'required|in:pending,confirmed,cancelled,completed',
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

        if (in_array($validated['status'], ['pending', 'confirmed'])) {
            $roomType->decrement('available_rooms', $validated['rooms_count']);
        }

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'payment_method' => 'cash',
            'status' => $validated['status'] === 'confirmed' ? 'paid' : 'pending',
        ]);
        
        if ($roomType->available_rooms <= 0) {
            $roomType->update(['status' => 'unavailable']);
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['roomType', 'guest', 'user', 'payment']);

        return view('admin.pages.booking.show', compact('booking'));
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
            'status' => 'required|in:pending,confirmed,cancelled,completed',
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

        $oldStatus = $booking->status;
        $oldRoomsCount = $booking->rooms_count;
        $oldRoomTypeId = $booking->room_type_id;

        $booking->update($validated);

        $statusChanged = $booking->wasChanged('status');

        $wasTaking = in_array($oldStatus, ['pending', 'confirmed']);
        $isTaking = in_array($validated['status'], ['pending', 'confirmed']);

        $oldRoomType = \App\Models\RoomType::find($oldRoomTypeId);

        if ($wasTaking && $oldRoomType) {
            $oldRoomType->increment('available_rooms', $oldRoomsCount);
            if ($oldRoomType->available_rooms > 0) {
                $oldRoomType->update(['status' => 'available']);
            }
        }

        if ($isTaking) {
            $roomType->decrement('available_rooms', $validated['rooms_count']);
            if ($roomType->available_rooms <= 0) {
                $roomType->update(['status' => 'unavailable']);
            } else {
                $roomType->update(['status' => 'available']);
            }
        }

        if ($booking->payment) {
            $booking->payment->update([
                'amount' => $validated['total_price'],
                'status' => $validated['status'] === 'confirmed' ? 'paid' : ($validated['status'] === 'cancelled' ? 'refunded' : 'pending'),
            ]);
        }

        if ($statusChanged && in_array($validated['status'], ['confirmed', 'cancelled', 'completed'])) {
            $guestEmail = $booking->email ?? ($booking->guest ? $booking->guest->email : null);
            if ($guestEmail) {
                try {
                    Mail::to($guestEmail)->send(new BookingStatusMail($booking));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
                    return redirect()->route('admin.booking.index')->with('success', 'Booking updated successfully. Note: Email failed to send (' . $e->getMessage() . ').');
                }
            }
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
        $wasTaking = in_array($booking->status, ['pending', 'confirmed']);
        $booking->update(['status' => 'confirmed']);

        if (!$wasTaking && $booking->roomType) {
            $booking->roomType->decrement('available_rooms', $booking->rooms_count);
        }

        if ($booking->payment) {
            $booking->payment->update(['status' => 'paid']);
        }
        
        if ($booking->roomType && $booking->roomType->available_rooms <= 0) {
            $booking->roomType->update(['status' => 'unavailable']);
        }

        $guestEmail = $booking->email ?? ($booking->guest ? $booking->guest->email : null);
        if ($guestEmail) {
            try {
                Mail::to($guestEmail)->send(new BookingStatusMail($booking));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
                return redirect()->back()->with('success', 'Booking confirmed successfully! Note: Email failed to send (' . $e->getMessage() . ').');
            }
        }

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $wasTaking = in_array($booking->status, ['pending', 'confirmed']);
        $booking->update(['status' => 'cancelled']);

        if ($wasTaking && $booking->roomType) {
            $booking->roomType->increment('available_rooms', $booking->rooms_count);
            if ($booking->roomType->available_rooms > 0) {
                $booking->roomType->update(['status' => 'available']);
            }
        }

        if ($booking->payment) {
            $booking->payment->update(['status' => 'refunded']);
        }

        $guestEmail = $booking->email ?? ($booking->guest ? $booking->guest->email : null);
        if ($guestEmail) {
            try {
                Mail::to($guestEmail)->send(new BookingStatusMail($booking));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
                return redirect()->back()->with('success', 'Booking cancelled successfully! Note: Email failed to send (' . $e->getMessage() . ').');
            }
        }

        return redirect()->back()->with('success', 'Booking cancelled successfully!');
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        $wasTaking = in_array($booking->status, ['pending', 'confirmed']);
        $booking->update(['status' => 'completed']);

        if ($wasTaking && $booking->roomType) {
            $booking->roomType->increment('available_rooms', $booking->rooms_count);
            if ($booking->roomType->available_rooms > 0) {
                $booking->roomType->update(['status' => 'available']);
            }
        }

        if ($booking->payment) {
            $booking->payment->update(['status' => 'paid']);
        }

        $guestEmail = $booking->email ?? ($booking->guest ? $booking->guest->email : null);
        if ($guestEmail) {
            try {
                Mail::to($guestEmail)->send(new BookingStatusMail($booking));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
                return redirect()->back()->with('success', 'Booking completed! Note: Email failed to send (' . $e->getMessage() . ').');
            }
        }

        return redirect()->back()->with('success', 'Booking marked as completed successfully!');
    }
}
