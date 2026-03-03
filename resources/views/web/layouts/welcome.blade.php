<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        nav a { margin: 10px; text-decoration: none; }
        footer { margin-top: 50px; text-align: center; padding: 20px; background: #f8f9fa; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">🏨 MyHotel</a>
        <div>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('rooms') }}">Our Rooms</a>
            <a href="{{ route('gallery') }}">Gallery</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('contact') }}">Contact Us</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<footer>
    <p>&copy; {{ date('Y') }} MyHotel. All Rights Reserved.</p>
</footer>

</body>
</html>
