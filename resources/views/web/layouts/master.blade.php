<!DOCTYPE html>
<html lang="en">
<head>
    @include('web.layouts.header.index')
</head>
<body>
    @include('web.layouts.header.nav')

    <main>
        @yield('content')
    </main>

    @include('web.layouts.footer.index')

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 5.5rem;">
        @if(session('success'))
            <div id="successToast" class="toast align-items-center text-white bg-success border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="errorToast" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        @if(session('login_locked'))
                            <div>Too many failed attempts! Please wait <span id="toastCountdown" class="fw-bold">{{ session('login_locked_seconds', 60) }}</span> second(s) before trying again.</div>
                        @else
                            <div>{{ session('error') }}</div>
                        @endif
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div id="validationToast" class="toast align-items-center text-white bg-danger border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2 fw-bold">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            <span>Please fix the following errors:</span>
                        </div>
                        <ul class="mb-0 ps-3 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

</body>
</html>
