<footer class="site-footer mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="footer-brand d-inline-flex align-items-center text-decoration-none">
                    <img src="{{ asset('images/logo.png') }}" alt="MyHotel Logo" class="footer-logo">
                    <span class="footer-brand-text">MyHotel</span>
                </a>
                <p class="footer-about">
                    Experience elegant rooms, warm hospitality, and memorable stays in one modern destination.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" aria-label="Youtube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="footer-title">Explore</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('rooms') }}">Rooms</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="footer-title">Discover</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('rooms') }}">Special Offers</a></li>
                    <li><a href="{{ route('contact') }}">Support</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h6 class="footer-title">Contact Us</h6>
                <ul class="footer-contact">
                    <li><i class="bi bi-geo-alt-fill"></i> City Center, Main Street, MyTown</li>
                    <li><i class="bi bi-envelope-fill"></i> info@myhotel.com</li>
                    <li><i class="bi bi-telephone-fill"></i> +1 (123) 456-7890</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="mb-0">&copy; {{ date('Y') }} MyHotel. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@php
    $openRegisterModal = session('open_auth_modal') === 'register';
    $openLoginModal = session('open_auth_modal') === 'login';
@endphp

@if ($openRegisterModal)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('registerModal')).show();
        });
    </script>
@elseif ($openLoginModal)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successToastEl = document.getElementById('successToast');
        if (successToastEl) {
            var successToast = new bootstrap.Toast(successToastEl, { delay: 6000 });
            successToast.show();
        }
        var errorToastEl = document.getElementById('errorToast');
        if (errorToastEl) {
            var errorToast = new bootstrap.Toast(errorToastEl, { delay: 6000 });
            errorToast.show();
        }
    });
</script>

<!-- AOS Animation JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically add AOS animation to headings, paragraphs, and cards on all pages
        const animatedElements = document.querySelectorAll('main h1, main h2, main h3, main h4, main h5, main p, main .feature-card, main .room-card, main .amenity-item, main .card, main img, footer');
        
        let delayCount = 0;
        let lastTop = 0;
        
        animatedElements.forEach((el, index) => {
            if(!el.hasAttribute('data-aos')) {
                // Determine animation type based on element
                let animType = 'fade-up';
                if(el.tagName === 'H1') animType = 'fade-down';
                else if(el.tagName === 'IMG' && !el.closest('.room-card')) animType = 'zoom-in';

                el.setAttribute('data-aos', animType);
                
                // Group elements by their vertical position to stagger animations properly
                let currentTop = el.getBoundingClientRect().top;
                if (Math.abs(currentTop - lastTop) > 50) {
                    delayCount = 0; // Reset delay for a new row/section
                    lastTop = currentTop;
                }
                
                let delay = delayCount * 100;
                if (delay > 500) delay = 500; // Cap delay
                
                el.setAttribute('data-aos-delay', delay.toString());
                delayCount++;
            }
        });

        AOS.init({
            duration: 900,
            easing: 'ease-in-out-cubic',
            once: true,
            offset: 40
        });
    });
</script>

@stack('scripts')
