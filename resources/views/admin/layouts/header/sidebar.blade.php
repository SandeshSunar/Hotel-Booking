<!-- Sidebar -->
<style>
    /* Custom Scrollbar for Sidebar */
    .sidebar-nav-scroll {
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #6c757d transparent;
    }
    .sidebar-nav-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-nav-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-nav-scroll::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        border-radius: 10px;
    }
</style>
<div class="bg-dark text-white p-3 vh-100 d-flex flex-column sticky-top" style="width: 220px;">
    <h5 class="text-uppercase border-bottom pb-2 mb-3 pe-2">Admin Menu</h5>
    
    <ul class="nav flex-column flex-grow-1 sidebar-nav-scroll pe-2">
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.dashboard.index') }}">🏠 Dashboard</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.booking.index') }}">📅 Bookings</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.room-types.index') }}">🛏️ Room Types</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.rooms.index') }}">🏨 Rooms</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.gallery.index') }}">🖼️ Gallery</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.message.index') }}">💬 Messages</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.blogs.index') }}">📝 Blogs</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.guest.index') }}">👥 Guests</a></li>
        <li class="nav-item mb-1"><a class="nav-link text-white rounded hover-bg-secondary" href="{{ route('admin.staff.index') }}">🧑‍💼 Staff</a></li>
    </ul>
    
    <div class="mt-auto pt-3 border-top border-secondary w-100">
        <form action="{{ route('logout') }}" method="POST" class="d-grid w-100" onsubmit="return confirm('Do you want to log out?');">
            @csrf
            <button type="submit" class="btn btn-danger fw-bold d-flex justify-content-between align-items-center py-2 px-3 rounded-3 shadow border-0" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <span class="text-white">Logout</span>
                <span class="fs-5 text-white"><i class="bi bi-person-circle"></i></span>
            </button>
        </form>
    </div>
</div>
