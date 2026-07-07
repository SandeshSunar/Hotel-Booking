@if($roomType && $roomType->images->isNotEmpty())
    <div class="mb-4">
        <label class="form-label d-block">Current Images</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach($roomType->images as $image)
                <div class="text-center">
                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="rounded border mb-2">
                    <form action="{{ route('admin.room-type-images.destroy', $image) }}" method="POST" onsubmit="return confirm('Remove this image?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Room Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach(\App\Models\RoomType::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" {{ old('category', $roomType->category ?? '') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Room Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $roomType->name ?? '') }}"
                placeholder="e.g. Deluxe Single Room" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Room Number</label>
            <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $roomType->room_number ?? '') }}" placeholder="e.g. 101">
        </div>
        <div class="col-md-4">
            <label class="form-label">Room Size</label>
            <input type="text" name="room_size" class="form-control" value="{{ old('room_size', $roomType->room_size ?? '') }}" placeholder="e.g. 24 sqm">
        </div>

        <div class="col-md-4">
            <label class="form-label">Price Per Night <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ old('price_per_night', $roomType->price_per_night ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Discount Price</label>
            <input type="number" step="0.01" name="discount_price" class="form-control" value="{{ old('discount_price', $roomType->discount_price ?? '') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Bed Type</label>
            <input type="text" name="bed_type" class="form-control" value="{{ old('bed_type', $roomType->bed_type ?? '') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Adult Capacity <span class="text-danger">*</span></label>
            <input type="number" name="capacity_adults" class="form-control" value="{{ old('capacity_adults', $roomType->capacity_adults ?? 1) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Children Capacity</label>
            <input type="number" name="capacity_children" class="form-control" value="{{ old('capacity_children', $roomType->capacity_children ?? 0) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Total Rooms <span class="text-danger">*</span></label>
            <input type="number" name="total_rooms" class="form-control" value="{{ old('total_rooms', $roomType->total_rooms ?? 1) }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
                <option value="available" {{ old('status', $roomType->status ?? 'available') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ old('status', $roomType->status ?? '') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Short Description</label>
            <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $roomType->short_description ?? '') }}">
        </div>
        <div class="col-12">
            <label class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" rows="4" class="form-control" required>{{ old('description', $roomType->description ?? '') }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Images @if(!$roomType || $roomType->images->isEmpty())<span class="text-danger">*</span>@endif</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*" {{ !$roomType || $roomType->images->isEmpty() ? 'required' : '' }}>
        </div>

        <div class="col-12">
            <label class="form-label d-block">Facilities</label>
            <div class="row g-2">
                @php
                    $predefinedFacilities = [
                        'Free Wi-Fi', 'Air Conditioning', 'Private Bathroom', 
                        'Hot & Cold Shower', 'Towels', 'Free Toiletries',  
                        'Electric Kettle', 'Tea/Coffee Maker',   
                        'Work Desk', 'Balcony', 'Room Service', 'Daily Housekeeping', 
                        'Safe Deposit Box', 'Restaurant', 'Bar', 'Free Parking', 
                        'Airport Shuttle', 'Outdoor Swimming Pool', 
                        '24-Hour Front Desk', 'Laundry Service', 
                        'Luggage Storage', 'Tour Desk', 'Car Rental', 
                        'CCTV', '24-Hour Security', 
                        'Smoke Detectors'
                    ];
                @endphp
                
                @foreach($predefinedFacilities as $facility)
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility }}" id="facility-{{ Str::slug($facility) }}"
                                {{ in_array($facility, $facilities ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="facility-{{ Str::slug($facility) }}">
                                {{ $facility }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                    {{ old('is_active', $roomType->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Enable this room type on the website</label>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success">Save Room Type</button>
        <a href="{{ route('admin.room-types.index') }}" class="btn btn-secondary">Back</a>
    </div>
</form>
