<!-- Top Navbar -->
<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">My Admin</a>

    <div class="ms-auto d-flex align-items-center text-white">
        <span class="me-3">Hi, <strong>{{ Auth::user()->name ?? 'Guest' }}</strong></span>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>
</nav>
