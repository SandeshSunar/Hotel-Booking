<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    // Show all rooms
    public function index()
    {
        $rooms = Room::all();
        return view('admin.pages.rooms.index', compact('rooms'));
    }

    // Show create form
    public function create()
    {
        return view('admin.pages.rooms.create');
    }

    // Store new room
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'type' => 'required',
            'price' => 'required|numeric',
            'wifi' => 'nullable|string',
            'status' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->only([
            'room_number',
            'type',
            'price',
            'wifi',
            'status',
            'description'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
    }

    // Show edit form
    public function edit(Room $room)
    {
        return view('admin.pages.rooms.edit', compact('room'));
    }

    // Update room
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => [
                'required',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
            ],
            'type' => 'required',
            'price' => 'required|numeric',
            'wifi' => 'nullable|string',
            'status' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->only([
            'room_number',
            'type',
            'price',
            'wifi',
            'status',
            'description'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    // Delete room
    public function destroy(Room $room)
    {
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}