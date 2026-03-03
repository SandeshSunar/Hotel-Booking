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
        $guests = Guest::all();
        return view('admin.pages.guest.index', compact('guests'));
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
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        Guest::create($request->all());

        return redirect()->route('admin.guest.index')->with('success', 'Guest added successfully.');
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
            'email' => 'required|email|unique:guests,email,' . $guest->id,
            'phone' => 'required|string',
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
