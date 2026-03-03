<footer class="bg-dark text-white py-3 mt-auto">
    <div class="container">
        <div class="row">
            <!-- About section -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h5>Simple Website</h5>
                <p class="small">Creating simple, effective websites.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-white text-decoration-none">About</a></li>
                    <li><a href="{{ route('rooms') }}" class="text-white text-decoration-none">Rooms</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-white text-decoration-none">Gallery</a></li>
                    <li><a href="{{ route('blog') }}" class="text-white text-decoration-none">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4">
                <h5>Contact</h5>
                <ul class="list-unstyled small">
                    <li><i class="bi bi-envelope me-2"></i> info@simplewebsite.com</li>
                    <li><i class="bi bi-phone me-2"></i> +1 (123) 456-7890</li>
                </ul>
            </div>
        </div>

        <hr class="my-2 bg-light">

        <!-- Bottom copyright -->
        <div class="text-center small">
            &copy; {{ date('Y') }} Simple Website. All rights reserved.
        </div>
    </div>
</footer>
