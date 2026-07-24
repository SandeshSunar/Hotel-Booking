{{-- @extends('admin.layouts.master')

@section('title', 'Edit Room')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">✏️ Edit Room</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($room->images->isNotEmpty())
        <div class="mb-4">
            <label class="form-label d-block">Current Images</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach($room->images as $image)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="rounded border mb-2">
                        <form action="{{ route('admin.room-images.destroy', $image->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this image?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger d-block mx-auto">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Room Number <span class="text-danger">*</span></label>
            <input type="text" name="room_number"
                class="form-control @error('room_number') is-invalid @enderror"
                value="{{ old('room_number', $room->room_number) }}" required>
            @error('room_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Room Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">-- Select Room Type --</option>
                <option value="deluxe" {{ old('type', $room->type) == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                <option value="suite" {{ old('type', $room->type) == 'suite' ? 'selected' : '' }}>Suite Room</option>
                <option value="family" {{ old('type', $room->type) == 'family' ? 'selected' : '' }}>Family Room</option>
                <option value="single" {{ old('type', $room->type) == 'single' ? 'selected' : '' }}>Single Room</option>
                <option value="double" {{ old('type', $room->type) == 'double' ? 'selected' : '' }}>Double Room</option>
                <option value="presidential" {{ old('type', $room->type) == 'presidential' ? 'selected' : '' }}>Presidential Room</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Price (Rs) <span class="text-danger">*</span></label>
            <input type="number" name="price"
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', $room->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Booked</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Wifi</label>
            <select name="wifi" class="form-select">
                <option value="yes" {{ old('wifi', $room->wifi) == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('wifi', $room->wifi) == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                rows="5" required>{{ old('description', $room->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Add New Images @if($room->images->isEmpty())<span class="text-danger">*</span>@endif</label>
            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" id="imageInput" multiple {{ $room->images->isEmpty() ? 'required' : '' }}>
            @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>

        <button type="submit" class="btn btn-success">Update Room</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(){
    const files = this.files;
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    if(files){
        Array.from(files).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.width = 100;
            img.className = 'rounded border';
            container.appendChild(img);
        });
    }
});
</script>
@endsection --}}
