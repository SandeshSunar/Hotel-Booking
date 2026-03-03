@extends('admin.layouts.master')

@section('title', 'Add Room')

@section('content')
<div class="p-4">
    <h4 class="fw-bold mb-3">➕ Add Room</h4>

    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" id="imageInput">
            <img id="preview" src="#" style="display:none;" width="100" class="mt-2 rounded">
        </div>

       <div class="mb-3">
            <label for="type" class="form-label">Room Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Room Type --</option>
                <option value="deluxe">Deluxe Room</option>
                <option value="suite">Suite Room</option>
                <option value="family">Family Room</option>
                <option value="single">Single Room</option>
                <option value="double">Double Room</option>
                <option value="presidential">Presidential Room</option>
            </select>
        </div>


        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Enter room description"></textarea>
        </div>


        <div class="mb-3">
            <label>Wifi</label>
            <select name="wifi" class="form-select" required>
                <option value="yes">Yes</option>
                <option value="no">No</opiton>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Room</button>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(){
    const [file] = this.files;
    if(file){
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'inline-block';
    }
});
</script>
@endsection
