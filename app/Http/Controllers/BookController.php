<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class BookController extends Controller 
{
    // Customer submits a booking
    public function store(Request $request) 
    {
        // Validate input
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => ['required', 'regex:/^[A-Za-z\s]+$/', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ], [
            'guest_name.regex' => 'Name must only contain letters.',
            'phone.regex' => 'Phone number must be exactly 10 digits.',
        ]);

        // Check room availability
        $alreadyBooked = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('check_in_date', '<=', $request->check_in)
                                ->where('check_out_date', '>=', $request->check_out);
                      });
            })
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'This room is already booked for the selected dates.');
        }

        // Save booking
        Booking::create([
            'room_id'        => $request->room_id,
            'guest_name'     => $request->guest_name,
            'phone'          => $request->phone,
            'check_in_date'  => $request->check_in,
            'check_out_date' => $request->check_out,
            'status'         => 'pending',
            'user_id'        => auth()->id() ?? null,  // Works for both guest & logged user
        ]);

        // Update room status
        Room::where('id', $request->room_id)->update(['status' => 'booked']);

        return redirect()->back()->with('success', 'Room booked successfully!');
    }
}
