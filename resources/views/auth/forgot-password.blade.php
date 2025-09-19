<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        /* Page Transition Animations */
        .auth-container {
            opacity: 0;
            animation: pageEnter 0.6s ease-out forwards;
        }

        @keyframes pageEnter {
            to {
                opacity: 1;
            }
        }

        .form-panel {
            transform: translateX(-30px);
            animation: slideInLeft 0.6s ease-out 0.1s forwards;
        }

        .illustration-panel {
            transform: translateX(30px);
            animation: slideInRight 0.6s ease-out 0.2s forwards;
        }

        @keyframes slideInLeft {
            to {
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
            }
        }

        /* Link Transition Effects */
        .auth-link a, .btn-secondary {
            position: relative;
            overflow: hidden;
        }

        .auth-link a::before, .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(13, 27, 42, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .auth-link a:hover::before, .btn-secondary:hover::before {
            left: 100%;
        }

        .auth-container {
            display: flex;
            height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .form-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 1rem;
        }

        .illustration-panel {
            flex: 1;
            background: #0D1B2A;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 20;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: radial-gradient(circle, #FFD700, #FFA500);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .logo-icon::before {
            content: '⚓';
            font-size: 24px;
            color: #0D1B2A;
            font-weight: bold;
        }

        .logo-text {
            color: #0D1B2A;
            font-weight: 700;
            font-size: 1.5rem;
            line-height: 1.2;
        }

        .form-content {
            width: 100%;
            max-width: 550px;
        }

        .form-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1B1B1B;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #5A5A5A;
            font-weight: 400;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1B1B1B;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #E5E5E5;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
            background: #FAFAFA;
        }

        .form-input:focus {
            outline: none;
            border-color: #0D1B2A;
            background: white;
            box-shadow: 0 0 0 3px rgba(13, 27, 42, 0.1);
        }

        .btn-primary {
            width: 100%;
            background: #0D1B2A;
            color: white;
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-bottom: 1.5rem;
        }

        .btn-primary:hover {
            background: #152C46;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .auth-link {
            text-align: center;
            color: #5A5A5A;
            font-size: 0.875rem;
        }

        .auth-link a {
            color: #0D1B2A;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-link a:hover {
            color: #152C46;
        }

        .illustration-content {
            position: absolute;
            top: 2rem;
            left: 2rem;
            text-align: left;
            color: white;
            z-index: 10;
        }

        .illustration-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0;
            line-height: 1.1;
        }

        .ship-silhouette {
            width: 300px;
            height: 200px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .ship-silhouette::before {
            content: '🚢';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            opacity: 0.7;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05), transparent);
            border-radius: 50%;
            opacity: 0.3;
        }

        .watermark::before {
            content: '⚓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.1);
        }

        .signin-prompt {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .signin-text {
            display: flex;
            flex-direction: column;
            color: white;
            margin: 0;
        }

        .signin-main {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .signin-sub {
            font-size: 0.875rem;
            margin: 0;
            opacity: 0.8;
        }

        .btn-secondary {
            background: white;
            color: #0D1B2A;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .illustration-panel {
                min-height: 300px;
                order: -1;
            }

            .logo {
                top: 1rem;
                left: 1rem;
            }

            .logo-text {
                font-size: 1.2rem;
            }

            .illustration-title {
                font-size: 1.2rem;
            }

            .ship-silhouette {
                width: 200px;
                height: 120px;
            }

            .illustration-content {
                position: relative;
                top: auto;
                right: auto;
                text-align: center;
                margin-top: 2rem;
            }

            .signin-prompt {
                position: relative;
                bottom: auto;
                right: auto;
                margin-top: 2rem;
            }

            .form-panel {
                padding: 1rem;
            }
        }
    </style>

    <div class="auth-container">
        <!-- Left Panel - Form -->
        <div class="form-panel">
            <div class="logo">
                <div class="logo-icon"></div>
                <div class="logo-text">
                    PALAPES<br>
                    LAUT UMS
                </div>
            </div>

            <div class="form-content">
                <h1 class="form-title">Forgot Password</h1>
                <p class="form-subtitle">No problem. Just let us know your email address and we will email you a password reset link.</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Your Email" />
                        <x-input-error :messages="$errors->get('email')" class="error-message" />
                    </div>

                    <button type="submit" class="btn-primary">
                        {{ __('Email Password Reset Link') }}
                    </button>

                    <div class="auth-link">
                        Remember your password? <a href="{{ route('login') }}" onclick="handlePageTransition(event, this.href)">Sign In</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Panel - Illustration -->
        <div class="illustration-panel">
            <div class="watermark"></div>

            <div class="illustration-content">
                <h2 class="illustration-title">Cadet Management &<br>Learning Hub</h2>
            </div>
            <div class="ship-silhouette"></div>

            <div class="signin-prompt">
                <div class="signin-text">
                    <p class="signin-main">Remember your password?</p>
                    <p class="signin-sub">Log back in</p>
                </div>
                <a href="{{ route('login') }}" class="btn-secondary" onclick="handlePageTransition(event, this.href)">Sign In</a>
            </div>
        </div>
    </div>

    <script>
        function handlePageTransition(event, targetUrl) {
            event.preventDefault();

            // Create transition overlay
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #0D1B2A 0%, #152C46 100%);
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.4s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-family: 'Inter', sans-serif;
            `;

            overlay.innerHTML = `
                <div style="text-align: center; animation: fadeInUp 0.5s ease;">
                    <div style="width: 50px; height: 50px; border: 3px solid rgba(255,255,255,0.3); border-top: 3px solid white; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1.5rem;"></div>
                    <div style="font-size: 1.1rem; font-weight: 500;">Switching to ${targetUrl.includes('login') ? 'Sign In' : 'Sign Up'}...</div>
                </div>
            `;

            document.body.appendChild(overlay);

            // Add animations
            const style = document.createElement('style');
            style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                @keyframes fadeInUp {
                    0% { opacity: 0; transform: translateY(20px); }
                    100: { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);

            // Fade current page
            document.querySelector('.auth-container').style.transition = 'transform 0.3s ease, opacity 0.3s ease';
            document.querySelector('.auth-container').style.transform = 'scale(0.95)';
            document.querySelector('.auth-container').style.opacity = '0.7';

            // Show overlay
            setTimeout(() => overlay.style.opacity = '1', 50);

            // Navigate after transition
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 600);
        }
    </script>
</x-guest-layout>
