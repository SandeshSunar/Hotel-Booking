<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    // Show all rooms
    public function index()
    {
        $rooms = Room::with('images')->latest()->get();
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
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ], [
            'room_number.required' => 'Room number is required.',
            'type.required' => 'Room type is required.',
            'price.required' => 'Price is required.',
            'description.required' => 'Description is required.',
            'images.required' => 'Room images are required.',
        ]);

        $data = $request->only([
            'room_number',
            'type',
            'price',
            'wifi',
            'status',
            'description'
        ]);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            // Store the first image in the main table for backward compatibility
            $data['image'] = $files[0]->store('rooms', 'public');
        }

        $room = Room::create($data);

        if ($request->hasFile('images')) {
            $sortOrder = 0;
            foreach ($request->file('images') as $file) {
                $sortOrder++;
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => $file->store('rooms', 'public'),
                    'sort_order' => $sortOrder,
                ]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
    }

    // Show edit form
    public function edit(Room $room)
    {
        $room->load('images');
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
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ], [
            'room_number.required' => 'Room number is required.',
            'type.required' => 'Room type is required.',
            'price.required' => 'Price is required.',
            'description.required' => 'Description is required.',
        ]);

        $data = $request->only([
            'room_number',
            'type',
            'price',
            'wifi',
            'status',
            'description'
        ]);

        // If new images are uploaded, save them
        if ($request->hasFile('images')) {
            $sortOrder = $room->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $file) {
                $sortOrder++;
                $path = $file->store('rooms', 'public');
                RoomImage::create([
                    'room_id' => $room->id,
                    'image_path' => $path,
                    'sort_order' => $sortOrder,
                ]);
            }

            // Update cover image if empty or not set
            if (!$room->image) {
                $firstImage = $room->images()->first();
                if ($firstImage) {
                    $data['image'] = $firstImage->image_path;
                }
            }
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    // Delete room
    public function destroy(Room $room)
    {
        // Delete all associated images
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Old image column cleanup
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }

    // Delete individual image
    public function destroyImage(RoomImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        
        $room = $image->room;
        $image->delete();

        // If the deleted image was set as the main cover image, update it to the next available image
        if ($room->image === $image->image_path) {
            $nextImage = $room->images()->first();
            $room->update(['image' => $nextImage ? $nextImage->image_path : null]);
        }

        return back()->with('success', 'Image removed successfully.');
    }
}