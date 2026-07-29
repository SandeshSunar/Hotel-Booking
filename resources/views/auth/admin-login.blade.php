<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - MyHotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth-page auth-page-simple">
    <div class="auth-wrapper-simple">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Admin Login</h2>
                <p>Sign in to access the dashboard</p>
            </div>

            @php $hasAdminError = $errors->any() || session('error'); @endphp

            @if ($hasAdminError)
                <div class="alert alert-danger auth-alert">
                    @if (session('error'))
                        {{ session('error') }}
                    @else
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            {{-- Lockout banner --}}
            <div id="lockout-banner" class="lockout-banner" style="display:none;">
                <div class="lockout-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <div class="lockout-text">
                    <strong>Too many failed attempts</strong>
                    <p>Please wait <span id="lockout-countdown" class="lockout-timer">60</span> seconds before trying again.</p>
                </div>
                <div class="lockout-progress-wrap">
                    <div id="lockout-progress" class="lockout-progress-bar"></div>
                </div>
            </div>

            <div id="attempts-warning" class="attempts-warning" style="display:none;">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="attempts-msg"></span>
            </div>

            @if (session('success'))
                <div class="alert alert-success auth-alert">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="auth-form" id="login-form">
                @csrf

                <div class="auth-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <label for="adminEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="adminEmail" name="email" value="{{ old('email') }}"
                           placeholder="Enter email" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-input-group">
                    <i class="bi bi-lock input-icon"></i>
                    <label for="adminPassword" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="adminPassword" name="password"
                           placeholder="Enter your password" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="auth-forgot">
                    <a href="{{ route('admin.password.request') }}" class="auth-link small">Forgot password?</a>
                </div>

                <button type="submit" class="auth-btn" id="login-btn">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .lockout-banner {
        background: linear-gradient(135deg, #2d1b1b 0%, #3d2020 100%);
        border: 1px solid rgba(239, 68, 68, 0.4);
        border-radius: 14px;
        padding: 18px 20px 14px;
        margin-bottom: 18px;
        text-align: center;
        animation: lockoutPulse 2s ease-in-out infinite;
    }
    @keyframes lockoutPulse {
        0%, 100% { border-color: rgba(239,68,68,0.4); box-shadow: 0 0 0 0 rgba(239,68,68,0); }
        50% { border-color: rgba(239,68,68,0.8); box-shadow: 0 0 12px 2px rgba(239,68,68,0.15); }
    }
    .lockout-icon { font-size: 2rem; color: #ef4444; margin-bottom: 6px; }
    .lockout-text strong { color: #fca5a5; font-size: 0.95rem; display: block; }
    .lockout-text p { color: #f87171; margin: 4px 0 12px; font-size: 0.88rem; }
    .lockout-timer {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ef4444;
        display: inline-block;
        min-width: 2ch;
        animation: timerPop 1s ease infinite;
    }
    @keyframes timerPop {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }
    .lockout-progress-wrap {
        background: rgba(239,68,68,0.15);
        border-radius: 99px;
        height: 6px;
        overflow: hidden;
    }
    .lockout-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #ef4444, #f97316);
        border-radius: 99px;
        transition: width 1s linear;
    }
    .attempts-warning {
        background: rgba(234,179,8,0.12);
        border: 1px solid rgba(234,179,8,0.35);
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        color: #fbbf24;
    }
    .attempts-warning i { font-size: 1rem; flex-shrink: 0; }
    #login-form.is-locked input,
    #login-form.is-locked button {
        pointer-events: none;
        opacity: 0.45;
        filter: grayscale(0.5);
    }
    </style>

    <script>
    (function() {
        const STORAGE_KEY  = 'mh_admin_login_lockout';
        const MAX_ATTEMPTS = 3;
        const LOCKOUT_SEC  = 60;
        const HAS_ERROR    = {{ $hasAdminError ? 'true' : 'false' }};

        const form        = document.getElementById('login-form');
        const banner      = document.getElementById('lockout-banner');
        const countdown   = document.getElementById('lockout-countdown');
        const progressBar = document.getElementById('lockout-progress');
        const warning     = document.getElementById('attempts-warning');
        const warnMsg     = document.getElementById('attempts-msg');
        const btn         = document.getElementById('login-btn');

        function getState() {
            try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || {}; }
            catch(e) { return {}; }
        }
        function setState(s) { localStorage.setItem(STORAGE_KEY, JSON.stringify(s)); }
        function clearState() { localStorage.removeItem(STORAGE_KEY); }

        function lockForm() {
            form.classList.add('is-locked');
            banner.style.display = 'block';
            warning.style.display = 'none';
            form.querySelectorAll('input').forEach(i => i.disabled = true);
            btn.disabled = true;
        }
        function unlockForm() {
            form.classList.remove('is-locked');
            banner.style.display = 'none';
            form.querySelectorAll('input').forEach(i => i.disabled = false);
            btn.disabled = false;
        }

        function startCountdown(remainingMs) {
            lockForm();
            const total = LOCKOUT_SEC * 1000;
            function tick() {
                const state = getState();
                if (!state.lockedUntil) { unlockForm(); return; }
                const rem = state.lockedUntil - Date.now();
                if (rem <= 0) {
                    clearState();
                    unlockForm();
                    return;
                }
                const secs = Math.ceil(rem / 1000);
                countdown.textContent = secs;
                const pct = (rem / total) * 100;
                progressBar.style.width = pct + '%';
                setTimeout(tick, 1000);
            }
            tick();
        }

        function showAttemptsWarning(attempts) {
            const left = MAX_ATTEMPTS - attempts;
            if (left <= 0) return;
            warning.style.display = 'flex';
            warnMsg.textContent = left === 1
                ? '1 attempt remaining before you are locked out for 60 seconds.'
                : left + ' attempts remaining before you are locked out for 60 seconds.';
        }

        const state = getState();
        if (state.lockedUntil) {
            const rem = state.lockedUntil - Date.now();
            if (rem > 0) {
                startCountdown(rem);
            } else {
                clearState();
            }
        } else if (HAS_ERROR) {
            const attempts = (state.attempts || 0) + 1;
            if (attempts >= MAX_ATTEMPTS) {
                const lockedUntil = Date.now() + LOCKOUT_SEC * 1000;
                setState({ attempts: 0, lockedUntil });
                startCountdown(LOCKOUT_SEC * 1000);
            } else {
                setState({ attempts });
                showAttemptsWarning(attempts);
            }
        } else if (state.attempts) {
            showAttemptsWarning(state.attempts);
        }
    })();
    </script>
</body>
</html>
