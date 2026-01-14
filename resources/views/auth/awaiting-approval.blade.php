<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Awaiting Approval</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

    {{-- ================================================================ --}}
    {{-- EXTERNAL RESOURCES --}}
    {{-- ================================================================ --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    
    {{-- ================================================================ --}}
    {{-- STYLES --}}
    {{-- ================================================================ --}}
    <style>
        /* ================================================================ */
        /* CSS VARIABLES */
        /* ================================================================ */
        :root {
            --primary-blue: #3c92d9;
            --secondary-blue: #2980b9;
            --accent-pink: #ec6c6c;
            --dark-navy: #2e313c;
            --darker-navy: #10141c;
            --light-gray: #f8fafc;
            --border-color: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #cbd5e1;
            --gradient-primary: linear-gradient(135deg, #3c92d9, #2980b9);
            --gradient-accent: linear-gradient(90deg, #3c92d9, #ec6c6c);
            --shadow-primary: 0 10px 30px rgba(60, 146, 217, 0.3);
            --shadow-hover: 0 20px 50px rgba(60, 146, 217, 0.4);
        }

        /* ================================================================ */
        /* BASE STYLES */
        /* ================================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-navy), var(--darker-navy));
            color: var(--text-primary);
            line-height: 1.7;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ================================================================ */
        /* SCROLLBAR */
        /* ================================================================ */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-navy);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 4px;
        }

        /* ================================================================ */
        /* NAVIGATION */
        /* ================================================================ */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(16, 20, 28, 0.95);
            backdrop-filter: blur(20px);
            padding: 1rem 2rem;
            z-index: 2000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar.scrolled {
            background: rgba(16, 20, 28, 0.98);
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.3);
            padding: 0.75rem 2rem;
        }

        .nav-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            max-width: 1400px;
            margin: 0;
            padding-left: 2rem;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.02);
        }

        .nav-logo img {
            width: auto;
            height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-text .main-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .nav-logo-text .sub-title {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1;
        }

        /* ================================================================ */
        /* HERO SECTION */
        /* ================================================================ */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            padding-bottom: 4rem;
            position: relative;
            background: radial-gradient(ellipse at center, rgba(60, 146, 217, 0.1) 0%, transparent 70%);
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--text-primary), var(--primary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.4rem);
            color: var(--text-secondary);
            margin-bottom: 3rem;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ================================================================ */
        /* FLOATING ELEMENTS */
        /* ================================================================ */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            top: 0;
            left: 0;
        }

        .floating-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(60, 146, 217, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-icon:nth-child(2) {
            top: 30%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-icon:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        .floating-icon:nth-child(4) {
            bottom: 20%;
            right: 10%;
            animation-delay: 1s;
        }

        /* ================================================================ */
        /* BUTTONS */
        /* ================================================================ */
        .btn-primary {
            background: var(--gradient-primary);
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: var(--shadow-primary);
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            background: var(--gradient-accent);
        }

        /* ================================================================ */
        /* FOOTER */
        /* ================================================================ */
        .footer {
            background: rgba(16, 20, 28, 0.98);
            padding: 3rem 2rem 2rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
            margin-top: auto;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gradient-accent);
        }

        .footer p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.95rem;
        }

        /* ================================================================ */
        /* ANIMATIONS */
        /* ================================================================ */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================================================================ */
        /* RESPONSIVE DESIGN - MOBILE */
        /* ================================================================ */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .hero-section {
                padding: 1rem;
                min-height: calc(100vh - 100px);
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-primary {
                padding: 14px 28px;
                font-size: 1rem;
            }

            .footer {
                padding: 2rem 1rem 1rem;
            }
        }
    </style>
</head>
<body>
    {{-- ================================================================ --}}
    {{-- NAVIGATION --}}
    {{-- ================================================================ --}}
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('logout.and.landing') }}" class="nav-logo">
                <img src="{{ asset('storage/assets/logo/PSS-LOGO.png') }}" alt="ROTU Logo">
                <div class="nav-logo-text">
                    <span class="main-title">PALAPES</span>
                    <span class="sub-title">LAUT UMS</span>
                </div>
            </a>
        </div>
    </nav>

    {{-- ================================================================ --}}
    {{-- HERO SECTION --}}
    {{-- ================================================================ --}}
    <section class="hero-section">
        <div class="floating-elements">
            <i class="fas fa-anchor floating-icon"></i>
            <i class="fas fa-shield-alt floating-icon"></i>
            <i class="fas fa-clock floating-icon"></i>
            <i class="fas fa-user-check floating-icon"></i>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">Registration Submitted</h1>
            <p class="hero-subtitle">
                Thank you for registering! Your account is pending approval by an administrator.
                <br><br>
                Please wait until your account is accepted. You will receive a notification once your account has been approved.
            </p>
            <a href="{{ route('logout.and.landing') }}" class="btn-primary">
                <i class="fas fa-arrow-left"></i>
                Back to Landing Page
            </a>
        </div>
    </section>

    {{-- ================================================================ --}}
    {{-- FOOTER --}}
    {{-- ================================================================ --}}
    <footer class="footer">
        <p>&copy; {{ date('Y') }} PALAPES Laut UMS | Cadet Management & Learning Hub</p>
    </footer>

    {{-- ================================================================ --}}
    {{-- SCRIPTS --}}
    {{-- ================================================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ================================================================
        // NAVBAR SCROLL EFFECTS
        // ================================================================
        let lastScrollY = window.scrollY;
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            lastScrollY = currentScrollY;
        });

        // ================================================================
        // PAGE LOADING ANIMATION
        // ================================================================
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';

            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>