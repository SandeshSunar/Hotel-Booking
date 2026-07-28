<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    // Show all guests
    public function index()
    {
        $guests = Guest::with('bookings.roomType')->get();
        
        $singleBookings = \App\Models\Booking::whereHas('roomType', function($q) { $q->where('category', 'single'); })->count();
        $doubleBookings = \App\Models\Booking::whereHas('roomType', function($q) { $q->where('category', 'double'); })->count();
        $familyBookings = \App\Models\Booking::whereHas('roomType', function($q) { $q->where('category', 'family'); })->count();

        $totalAdults = \App\Models\Booking::sum('adults');
        $totalChildren = \App\Models\Booking::sum('children');
        $totalGuests = $totalAdults + $totalChildren;

        return view('admin.pages.guest.index', compact('guests', 'singleBookings', 'doubleBookings', 'familyBookings', 'totalAdults', 'totalChildren', 'totalGuests'));
    }

    // Show create form
    public function create()
    {
        return view('admin.pages.guest.create');
    }

    // Store new guest
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:guests,email',
            'phone' => 'required|digits:10|unique:guests,phone',
            'address' => 'required|string',
        ]);

        Guest::create($request->all());

        return redirect()->route('admin.guest.index')->with('success', 'Guest added successfully.');
    }

    // Show guest details
    public function show(Guest $guest)
    {
        $guest->load('bookings.roomType');
        return view('admin.pages.guest.show', compact('guest'));
    }

    // Show edit form
    public function edit(Guest $guest)
    {
        return view('admin.pages.guest.edit', compact('guest'));
    }

    // Update guest
    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:guests,email,'.$guest->id,
            'phone' => 'required|digits:10|unique:guests,phone,'.$guest->id,
            'address' => 'required|string',
        ]);

        $guest->update($request->all());

        return redirect()->route('admin.guest.index')->with('success', 'Guest updated successfully.');
    }

    // Delete guest
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()->route('admin.guest.index')->with('success', 'Guest deleted successfully.');
    }
}
