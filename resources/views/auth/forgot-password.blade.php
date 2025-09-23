<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Base Container */
        .auth-container {
            display: flex;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            opacity: 0;
            animation: pageEnter 0.6s ease-out forwards;
        }
        
        @keyframes pageEnter {
            to { opacity: 1; }
        }
        
        /* Desktop Layout */
        .form-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem;
            min-height: 100vh;
        }
        
        /* Background Logo for Form Panel */
        .form-panel::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background-image: url('storage/assets/logo/PSS-LOGO.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.08;
            z-index: 1;
            pointer-events: none;
        }
        
        .illustration-panel {
            flex: 1;
            background: #0D1B2A;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            min-height: 100vh;
        }
        
        .form-content {
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 10;
        }
        
        .form-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1B1B1B;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .form-subtitle {
            color: #5A5A5A;
            font-weight: 400;
            margin-bottom: 2rem;
            text-align: center;
            line-height: 1.5;
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
            padding: 1rem;
            border: 2px solid #E5E5E5;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: rgba(250, 250, 250, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .form-input:focus {
            outline: none;
            border-color: #0D1B2A;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(13, 27, 42, 0.1);
        }
        
        .btn-primary {
            width: 100%;
            background: #0D1B2A;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 2rem;
        }
        
        .btn-primary:hover {
            background: #152C46;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 27, 42, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .auth-link {
            text-align: center;
            color: #5A5A5A;
            font-size: 0.9rem;
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
        
        /* Success Message */
        .success-message {
            background: rgba(212, 237, 218, 0.95);
            color: #155724;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #c3e6cb;
            text-align: center;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        
        /* Illustration Panel */
        .illustration-image {
            width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(135deg, rgba(13, 27, 42, 0.8), rgba(21, 44, 70, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .illustration-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.3;
        }
        
        .illustration-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(13, 27, 42, 0.8), rgba(21, 44, 70, 0.7));
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2rem;
            z-index: 10;
        }
        
        .illustration-content {
            text-align: left;
            color: white;
        }
        
        .illustration-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
        }
        
        .illustration-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            line-height: 1.4;
        }
        
        .auth-prompt {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .auth-text {
            display: flex;
            flex-direction: column;
            color: white;
            margin: 0;
        }
        
        .auth-main {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }
        
        .auth-sub {
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
        
        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #0D1B2A 0%, #152C46 100%);
            padding: 1.5rem;
            text-align: center;
            z-index: 100;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .mobile-bottom-nav .auth-text {
            color: white;
            margin-bottom: 1rem;
        }
        
        .mobile-bottom-nav .auth-main {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .mobile-bottom-nav .auth-sub {
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        .mobile-bottom-nav .btn-secondary {
            background: white;
            color: #0D1B2A;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
            min-width: 120px;
        }
        
        .mobile-bottom-nav .btn-secondary:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 1024px) {
            .auth-container {
                flex-direction: column;
                min-height: 100vh;
            }
            
            .illustration-panel {
                display: none;
            }
            
            .mobile-bottom-nav {
                display: block;
            }
            
            .form-panel {
                flex: 1;
                min-height: calc(100vh - 120px);
                padding: 1.5rem;
                padding-bottom: 140px;
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            }
            
            /* Mobile Background Logo */
            .form-panel::before {
                width: 250px;
                height: 250px;
                opacity: 0.06;
            }
            
            .form-content {
                max-width: 400px;
                background: rgba(255, 255, 255, 0.95);
                padding: 2rem;
                border-radius: 20px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(20px);
                margin: 0 auto;
            }
            
            .form-title {
                font-size: 2rem;
            }
            
            .form-subtitle {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .form-panel {
                padding: 1rem;
                padding-bottom: 140px;
            }
            
            .form-panel::before {
                width: 200px;
                height: 200px;
                opacity: 0.05;
            }
            
            .form-content {
                padding: 1.5rem;
                border-radius: 16px;
            }
            
            .form-title {
                font-size: 1.75rem;
            }
            
            .form-input {
                padding: 0.875rem;
                font-size: 0.95rem;
            }
            
            .btn-primary {
                padding: 0.875rem;
                font-size: 1rem;
            }
        }
    </style>

    <div class="auth-container">
        <!-- Form Panel -->
        <div class="form-panel">
            <div class="form-content">
                <h1 class="form-title">Reset Password</h1>
                <p class="form-subtitle">Enter your email address and we'll send you a link to reset your password</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email address" />
                        <x-input-error :messages="$errors->get('email')" class="error-message" />
                    </div>

                    <button type="submit" class="btn-primary">
                        Send Reset Link
                    </button>

                    <div class="auth-link">
                        Remember your password? <a href="{{ route('login') }}">Back to sign in</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Illustration Panel - Desktop Only -->
        <div class="illustration-panel">
            <div class="illustration-image">
                <img src="storage/assets/images/tldm1.jpg" alt="Naval Security" />
                <div class="illustration-overlay">
                    <div class="illustration-content">
                        <h2 class="illustration-title">Cadet Management &<br>Learning Hub</h2>
                        <p class="illustration-subtitle">Secure Access Recovery</p>
                    </div>

                    <div class="auth-prompt">
                        <div class="auth-text">
                            <p class="auth-main">Remember your password?</p>
                            <p class="auth-sub">Log back in</p>
                        </div>
                        <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <div class="auth-text">
            <p class="auth-main">Remember your password?</p>
            <p class="auth-sub">Go back to sign in</p>
        </div>
        <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
    </div>

    <!-- Font Awesome for consistency -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-guest-layout>