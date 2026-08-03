<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\RoomTypeFacility;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomType::with(['images', 'facilities'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('room_number', 'like', "%{$search}%");
        }

        $roomTypes = $query->get();

        return view('admin.pages.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.pages.room-types.create');
    }

    public function show(RoomType $roomType)
    {
        $roomType->load(['images', 'facilities']);
        return view('admin.pages.room-types.show', compact('roomType'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRoomType($request);
        $data = $this->roomTypeData($request, $validated);
        $data['slug'] = $this->makeUniqueSlug($data['name'], $data['room_number'] ?? null);
        $data['available_rooms'] = $data['total_rooms'];

        $roomType = RoomType::create($data);

        $this->syncImages($request, $roomType);
        $this->syncFacilities($request, $roomType);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room added successfully.');
    }

    public function edit(RoomType $roomType)
    {
        $roomType->load(['images', 'facilities']);

        return view('admin.pages.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $this->validateRoomType($request, $roomType);
        $data = $this->roomTypeData($request, $validated);

        $diff = $validated['total_rooms'] - $roomType->total_rooms;
        $data['available_rooms'] = max(0, $roomType->available_rooms + $diff);
        $data['slug'] = $this->makeUniqueSlug($data['name'], $data['room_number'] ?? null, $roomType->id);

        $roomType->update($data);

        $this->syncImages($request, $roomType);
        $this->syncFacilities($request, $roomType);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        foreach ($roomType->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room deleted successfully.');
    }

    public function destroyImage(RoomTypeImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image removed successfully.');
    }

    private function validateRoomType(Request $request, ?RoomType $roomType = null): array
    {
        return $request->validate([
            'category' => ['required', Rule::in(array_keys(RoomType::CATEGORIES))],
            'name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price_per_night' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'room_size' => 'nullable|string|max:100',
            'bed_type' => 'nullable|string|max:100',
            'capacity_adults' => 'required|integer|min:1',
            'capacity_children' => 'required|integer|min:0',
            'total_rooms' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable',
            'is_active' => 'nullable|boolean',
            'images' => ($roomType && $roomType->images()->count() > 0 ? 'nullable' : 'required') . '|array' . ($roomType && $roomType->images()->count() > 0 ? '' : '|min:1'),
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'facilities' => 'nullable|array',
            'facilities.*' => 'nullable|string|max:255',
        ], [
            'category.required' => 'Please select Single, Double, or Family room category.',
            'name.required' => 'Room name is required.',
            'description.required' => 'Description is required.',
            'price_per_night.required' => 'Price per night is required.',
            'images.required' => 'At least one room image is required.',
        ]);
    }

    private function roomTypeData(Request $request, array $validated): array
    {
        return [
            'category' => $validated['category'],
            'name' => $validated['name'],
            'room_number' => $validated['room_number'] ?? null,
            'description' => $validated['description'],
            'short_description' => $validated['short_description'] ?? null,
            'price_per_night' => $validated['price_per_night'],
            'discount_price' => $validated['discount_price'] ?? null,
            'room_size' => $validated['room_size'] ?? null,
            'bed_type' => $validated['bed_type'] ?? null,
            'capacity_adults' => $validated['capacity_adults'],
            'capacity_children' => $validated['capacity_children'],
            'total_rooms' => $validated['total_rooms'],
            'status' => $validated['status'],
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function makeUniqueSlug(string $name, ?string $roomNumber = null, ?int $ignoreId = null): string
    {
        $base = Str::slug(trim($name . ' ' . ($roomNumber ?? '')));
        $slug = $base;
        $counter = 1;

        while (
            RoomType::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function syncImages(Request $request, RoomType $roomType): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $sortOrder = $roomType->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $sortOrder++;
            RoomTypeImage::create([
                'room_type_id' => $roomType->id,
                'image_path' => $file->store('room-types', 'public'),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function syncFacilities(Request $request, RoomType $roomType): void
    {
        if (!$request->has('facilities')) {
            return;
        }

        $roomType->facilities()->delete();

        foreach ($request->input('facilities', []) as $facility) {
            $name = trim((string) $facility);
            if ($name === '') {
                continue;
            }

            RoomTypeFacility::create([
                'room_type_id' => $roomType->id,
                'name' => $name,
            ]);
        }
    }
}
