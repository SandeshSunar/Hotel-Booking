@extends('admin.layouts.master')

@section('title', 'Add Room')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Room</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Room Number <span class="text-danger">*</span></label>
            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror"
                value="{{ old('room_number') }}" required>
            @error('room_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Images <span class="text-danger">*</span></label>
            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" id="imageInput" multiple required>
            @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Room Type <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">-- Select Room Type --</option>
                <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe Room</option>
                <option value="suite" {{ old('type') == 'suite' ? 'selected' : '' }}>Suite Room</option>
                <option value="family" {{ old('type') == 'family' ? 'selected' : '' }}>Family Room</option>
                <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single Room</option>
                <option value="double" {{ old('type') == 'double' ? 'selected' : '' }}>Double Room</option>
                <option value="presidential" {{ old('type') == 'presidential' ? 'selected' : '' }}>Presidential Room</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Price <span class="text-danger">*</span></label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price') }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                rows="5" placeholder="Enter room description" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Wifi</label>
            <select name="wifi" class="form-select" required>
                <option value="yes" {{ old('wifi', 'yes') == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ old('wifi') == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Room</button>
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
@endsection
