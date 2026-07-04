<!-- Sidebar -->
<div class="bg-dark text-white p-3 vh-100" style="width: 220px;">
    <h5 class="text-uppercase border-bottom pb-2 mb-3">Admin Menu</h5>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.dashboard.index') }}">🏠 Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.booking.index') }}">📅 Bookings</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.room-types.index') }}">🛏️ Room Types</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.gallery.index') }}">🖼️ Gallery</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.message.index') }}">💬 Messages</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.guest.index') }}">👥 Guests</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.staff.index') }}">🧑‍💼 Staff</a></li>
        
    </ul>
</div>
