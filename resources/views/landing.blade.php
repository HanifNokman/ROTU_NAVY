<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVE OFFICER TRAINING UNIT - UMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
            background-color: #2e313c;
            color: white;
            line-height: 1.6;
        }

        /* Gradient utilities */
        .gradient-divider {
            width: 80%;
            height: 2px;
            background: linear-gradient(90deg, #3c92d9, #ec6c6c);
            margin: 4rem auto;
        }

        .gradient-divider-angled {
            width: 80%;
            height: 2px;
            background: linear-gradient(90deg, #3c92d9, #ec6c6c);
            margin: 4rem auto;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: #2e313c;
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            z-index: 1000;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .nav-logo span {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }

        .nav-links a:hover {
            color: #ffffff;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #3c92d9;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn-primary {
            background: #3c92d9;
            padding: 14px 28px;
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(60, 146, 217, 0.4);
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: white;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Hero Carousel Section */
        .hero-carousel {
            position: relative;
            height: 100vh;
            overflow: hidden;
            margin-top: 80px;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-slide:nth-child(1) {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect width="1200" height="600" fill="%23313541"/><rect x="0" y="200" width="1200" height="200" fill="%23373a46"/><circle cx="300" cy="300" r="50" fill="%233c92d9" opacity="0.3"/><circle cx="900" cy="200" r="80" fill="%2360bc8c" opacity="0.2"/><rect x="200" y="400" width="800" height="100" fill="%23373a46" opacity="0.8"/></svg>') center/cover;
        }

        .carousel-slide:nth-child(2) {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect width="1200" height="600" fill="%23373a46"/><rect x="100" y="100" width="1000" height="400" fill="%23313541"/><circle cx="600" cy="300" r="100" fill="%233c92d9" opacity="0.2"/><rect x="300" y="450" width="600" height="50" fill="%2360bc8c" opacity="0.3"/></svg>') center/cover;
        }

        .carousel-slide:nth-child(3) {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect width="1200" height="600" fill="%23313541"/><polygon points="0,0 400,100 800,50 1200,150 1200,600 0,600" fill="%23373a46"/><circle cx="200" cy="150" r="30" fill="%233c92d9" opacity="0.4"/><circle cx="1000" cy="250" r="40" fill="%2360bc8c" opacity="0.3"/></svg>') center/cover;
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 2;
        }

        .carousel-caption h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            animation: fadeInUp 1s ease;
            color: white;
        }

        .carousel-caption p {
            font-size: 1.8rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            animation: fadeInUp 1s ease 0.3s both;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(46, 49, 60, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1.5rem;
            padding: 0.8rem 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border-radius: 4px;
        }

        .carousel-nav:hover {
            background: rgba(60, 146, 217, 0.8);
            border-color: #3c92d9;
        }

        .carousel-prev {
            left: 2rem;
        }

        .carousel-next {
            right: 2rem;
        }

        .carousel-dots {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: #3c92d9;
            transform: scale(1.2);
        }

        .carousel-dot:hover {
            background: #3c92d9;
        }

        /* Section Container */
        .section {
            margin: 0;
            padding: 6rem 2rem;
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .section-content {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .card {
            background: rgba(46, 49, 60, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 8px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        /* Introduction Section */
        .introduction-section {
            background: linear-gradient(rgba(46, 49, 60, 0.3), rgba(46, 49, 60, 0.3)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect width="1200" height="800" fill="%23373a46"/><circle cx="200" cy="200" r="100" fill="%233c92d9" opacity="0.1"/><circle cx="1000" cy="600" r="150" fill="%2360bc8c" opacity="0.1"/><rect x="300" y="300" width="600" height="200" fill="%23313541" opacity="0.3"/></svg>') center/cover;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .intro-image {
            width: 100%;
            border-radius: 8px;
            border: 2px solid rgba(60, 146, 217, 0.3);
            transition: all 0.3s ease;
        }

        .intro-image:hover {
            transform: scale(1.02);
            border-color: #3c92d9;
        }

        /* About Section */
        .about-section {
            background: #2e313c;
            text-align: center;
        }

        .about-photo {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 3rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        /* Transition Image */
        .transition-image {
            height: 400px;
            background: linear-gradient(rgba(46, 49, 60, 0.4), rgba(46, 49, 60, 0.4)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><rect width="1200" height="400" fill="%23313541"/><polygon points="0,100 300,50 600,120 900,70 1200,100 1200,400 0,400" fill="%23373a46"/><circle cx="400" cy="150" r="50" fill="%233c92d9" opacity="0.2"/><circle cx="800" cy="200" r="70" fill="%2360bc8c" opacity="0.2"/></svg>') center/cover;
            margin: 0;
        }

        /* Benefits Section */
        .benefits-section {
            background: linear-gradient(to bottom, 
                        transparent 0%, 
                        rgba(46, 49, 60, 0.8) 50%, 
                        #2e313c 100%),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect width="1200" height="400" fill="%23313541"/><rect x="0" y="400" width="1200" height="400" fill="%232e313c"/></svg>') top/cover;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .benefit-card {
            background: rgba(46, 49, 60, 0.9);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0;
            transform: translateY(30px);
            animation: bounceIn 0.8s ease forwards;
        }

        .benefit-card:nth-child(1) { animation-delay: 0.1s; }
        .benefit-card:nth-child(2) { animation-delay: 0.2s; }
        .benefit-card:nth-child(3) { animation-delay: 0.3s; }
        .benefit-card:nth-child(4) { animation-delay: 0.4s; }
        .benefit-card:nth-child(5) { animation-delay: 0.5s; }

        .benefit-card:hover {
            transform: translateY(-10px);
            background: rgba(60, 146, 217, 0.1);
            border-color: #3c92d9;
        }

        .benefit-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #3c92d9;
        }

        /* Requirements Section */
        .requirements-section {
            background: linear-gradient(rgba(46, 49, 60, 0.3), rgba(46, 49, 60, 0.3)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect width="1200" height="800" fill="%23373a46"/><rect x="100" y="100" width="400" height="600" fill="%23313541" opacity="0.5"/><rect x="700" y="200" width="400" height="400" fill="%232e313c" opacity="0.5"/><circle cx="900" cy="400" r="80" fill="%233c92d9" opacity="0.2"/></svg>') center/cover;
        }

        .requirements-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid rgba(60, 146, 217, 0.3);
        }

        .requirements-list {
            background: rgba(46, 49, 60, 0.9);
            padding: 3rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Join Us Section */
        .join-section {
            background: linear-gradient(rgba(46, 49, 60, 0.3), rgba(46, 49, 60, 0.3)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect width="1200" height="800" fill="%23313541"/><polygon points="200,100 800,150 1000,200 1200,100 1200,800 0,800 0,200" fill="%23373a46" opacity="0.7"/><circle cx="300" cy="300" r="60" fill="%2360bc8c" opacity="0.3"/><circle cx="900" cy="500" r="90" fill="%233c92d9" opacity="0.2"/></svg>') center/cover;
        }

        .qr-card {
            background: rgba(46, 49, 60, 0.9);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .qr-card:hover {
            transform: scale(1.05);
            border: 2px solid #3c92d9;
            box-shadow: 0 0 30px rgba(60, 146, 217, 0.3);
        }

        .qr-code {
            width: 200px;
            height: 200px;
            background: white;
            margin: 0 auto;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-size: 0.8rem;
        }

        /* Footer */
        .footer {
            background: #2e313c;
            padding: 4rem 2rem 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-section h3 {
            color: #3c92d9;
            margin-bottom: 1rem;
            border-bottom: 2px solid #3c92d9;
            padding-bottom: 0.5rem;
        }

        .footer-map {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            padding: 2rem;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .social-icon:hover {
            background: #3c92d9;
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(60, 146, 217, 0.4);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3) translateY(30px);
            }
            50% {
                opacity: 1;
                transform: scale(1.1) translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .slide-left {
            opacity: 0;
            transform: translateX(-50px);
            animation: slideInLeft 1s ease forwards;
        }

        .slide-right {
            opacity: 0;
            transform: translateX(50px);
            animation: slideInRight 1s ease forwards;
        }

        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .zoom-in {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.8s ease;
        }

        .zoom-in.visible {
            opacity: 1;
            transform: scale(1);
        }

        h2 {
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
            color: white;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 80px;
            height: 2px;
            background: #3c92d9;
            transform: translateX(-50%);
        }

        ul {
            list-style: none;
        }

        li {
            padding: 0.8rem 0;
            position: relative;
            font-size: 1.1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #2e313c;
                flex-direction: column;
                padding: 2rem;
                gap: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .carousel-caption h1 {
                font-size: 2.5rem;
            }

            .carousel-caption p {
                font-size: 1.2rem;
            }

            .carousel-nav {
                font-size: 1.2rem;
                padding: 0.6rem 0.8rem;
            }

            .carousel-prev {
                left: 1rem;
            }

            .carousel-next {
                right: 1rem;
            }

            .two-column {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .section {
                padding: 4rem 1rem;
                min-height: auto;
            }

            .card {
                padding: 2rem;
            }

            h2 {
                font-size: 2.2rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .carousel-caption h1 {
                font-size: 2rem;
            }

            .carousel-caption p {
                font-size: 1rem;
            }

            .section {
                padding: 3rem 1rem;
            }

            .benefit-icon {
                font-size: 2.5rem;
            }

            .qr-code {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiMzYzkyZDkiLz4KPHN2ZyB4PSI1IiB5PSI1IiB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCAzMCAzMCIgZmlsbD0ibm9uZSI+CjxwYXRoIGQ9Ik0xNSAyTDE4IDhIMjZMMjAgMTJMMjIgMjBIMTVMMTMgMjBMMjAgMTJMMTQgOEwyMiA4TDE5IDJIMTVaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4KPC9zdmc+" alt="ROTU Logo">
                <span>ROTU NAVY UMS</span>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="#introduction">Introduction</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#benefits">Benefits</a></li>
                <li><a href="#requirements">Requirements</a></li>
                <li><a href="#join">Join Us</a></li>
                
                <!-- Authentication-based navigation -->
                <!-- @auth -->
                    <!-- @php
                        $dashboardRoute = match (auth()->user()->role) {
                            'cadet' => 'cadet.dashboard',
                            'instructor' => 'instructor.dashboard',
                            'admin' => 'admin.dashboard',
                            default => null
                        };
                    @endphp -->
                    <!-- @if($dashboardRoute) -->
                        <li><a href="{{ route($dashboardRoute) }}" class="btn-primary">Dashboard</a></li>
                    <!-- @endif -->
                <!-- @else -->
                    <!-- If user is not logged in, show Login button -->
                    <li><a href="{{ route('login') }}" class="btn-primary">Log In</a></li>
                <!-- @endauth -->
            </ul>
            <div class="mobile-menu-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel Section -->
    <section class="hero-carousel">
        <div class="carousel-container">
            <div class="carousel-slide active">
                <div class="carousel-caption">
                    <h1>RESERVE OFFICER TRAINING UNIT</h1>
                    <p>Universiti Malaysia Sabah</p>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-caption">
                    <h1>LEADERSHIP EXCELLENCE</h1>
                    <p>Developing Tomorrow's Naval Leaders</p>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-caption">
                    <h1>MARITIME TRAINING</h1>
                    <p>Professional Naval & Leadership Skills</p>
                </div>
            </div>
        </div>
        
        <button class="carousel-nav carousel-prev" id="prevBtn">‹</button>
        <button class="carousel-nav carousel-next" id="nextBtn">›</button>
        
        <div class="carousel-dots">
            <span class="carousel-dot active" data-slide="0"></span>
            <span class="carousel-dot" data-slide="1"></span>
            <span class="carousel-dot" data-slide="2"></span>
        </div>
    </section>

    <div class="gradient-divider"></div>

    <!-- Introduction Section -->
    <section id="introduction" class="section introduction-section">
        <div class="section-content">
            <div class="two-column">
                <div class="slide-right">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjMzczYTQ2IiByeD0iOCIvPgo8c3ZnIHg9IjEwMCIgeT0iMTAwIiB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEwMCI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjM2M5MmQ5IiBvcGFjaXR5PSIwLjMiLz4KPC9Tdmc+Cjx0ZXh0IHg9IjIwMCIgeT0iMTUwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkb21pbmFudC1iYXNlbGluZT0ibWlkZGxlIiBmaWxsPSJ3aGl0ZSIgZm9udC1zaXplPSIxOCI+SW50cm9kdWN0aW9uIEltYWdlPC90ZXh0Pgo8c3ZnPgo=" alt="Introduction Image" class="intro-image">
                </div>
                <div class="slide-left">
                    <div class="card">
                        <h2>Introduction</h2>
                        <p style="font-size: 1.1rem; line-height: 1.8; margin-top: 2rem;">
                            The Reserve Officer Training Unit (PALAPES) Laut UMS is a structured military training program designed to develop leadership, discipline, and maritime skills among university students. It combines rigorous training in navigation, seamanship, physical fitness, and military skills.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gradient-divider"></div>

    <!-- About Section -->
    <section id="about" class="section about-section">
        <div class="section-content">
            <div class="card fade-in">
                <h2>About</h2>
                <p style="text-align: center; font-size: 1.1rem; line-height: 1.8; margin: 3rem 0;">
                    The Reserve Officer Training Unit (PALAPES) is a university-level program that Graduate can be commissioned as Second Lieutenant Officers Naval Volunteer Reserve (NVR). Developing leadership excellence and instilling discipline, PALAPES offers a unique opportunity for cadets seeking dynamic leadership in both military and civilian careers. Beyond the physical and technical skills, PALAPES builds character, teamwork, and resilience.
                </p>
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwMCIgaGVpZ2h0PSIzMDAiIHZpZXdCb3g9IjAgMCAxMDAwIDMwMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjEwMDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjMzczYTQ2IiByeD0iOCIvPgo8c3ZnIHg9IjEwMCIgeT0iNTAiPgo8cmVjdCB3aWR0aD0iODAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iIzNjOTJkOSIgb3BhY2l0eT0iMC4yIi8+CjwvU3ZnPgo8c3ZnIHg9IjIwMCIgeT0iMTAwIj4KPHJlY3Qgd2lkdGg9IjYwMCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiM2MGJjOGMiIG9wYWNpdHk9IjAuMyIvPgo8L3N2Zz4KPHRleHQgeD0iNTAwIiB5PSIxNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiIGZpbGw9IndoaXRlIiBmb250LXNpemU9IjI0Ij5MYXJnZSBDYWRldCBHcm91cCBQaG90bzwvdGV4dD4KPHN2Zz4K" alt="Large Cadet Group Photo" class="about-photo zoom-in">
            </div>
        </div>
    </section>

    <!-- Transition Image -->
    <div class="transition-image"></div>

    <!-- Benefits Section -->
    <section id="benefits" class="section benefits-section">
        <div class="section-content">
            <h2>Benefits</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <h3>Monthly Allowance</h3>
                    <p>Receive financial support throughout your training period</p>
                </div>
                <div class="benefit-card">
                    <h3>Issued Uniform & Gear</h3>
                    <p>Complete uniform and equipment provided by the program</p>
                </div>
                <div class="benefit-card">
                    <h3>Guaranteed Campus Accommodation</h3>
                    <p>Secure housing during your university years</p>
                </div>
                <div class="benefit-card">
                    <h3>Firearms & Naval Training</h3>
                    <p>Professional military and maritime skills development</p>
                </div>
                <div class="benefit-card">
                    <h3>Leadership Development</h3>
                    <p>Build essential leadership capabilities for your future</p>
                </div>
            </div>
        </div>
    </section>

    <div class="gradient-divider"></div>

    <!-- Requirements Section -->
    <section id="requirements" class="section requirements-section">
        <div class="section-content">
            <div class="two-column">
                <div class="slide-left">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjMzczYTQ2IiByeD0iOCIvPgo8c3ZnIHg9IjUwIiB5PSI1MCI+CjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjM2M5MmQ5IiBvcGFjaXR5PSIwLjIiLz4KPC9Tdmc+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjE1MCIgcj0iNTAiIGZpbGw9IiM2MGJjOGMiIG9wYWNpdHk9IjAuMyIvPgo8Y2lyY2xlIGN4PSIxNTAiIGN5PSIyNTAiIHI9IjMwIiBmaWxsPSIjM2M5MmQ5IiBvcGFjaXR5PSIwLjQiLz4KPHRleHQgeD0iMjAwIiB5PSIzNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiIGZpbGw9IndoaXRlIiBmb250LXNpemU9IjE4Ij5UZWFtd29yayBFeGVyY2lzZTwvdGV4dD4KPHN2Zz4K" alt="Cadets Teamwork Exercise" class="requirements-image">
                </div>
                <div class="slide-right">
                    <div class="requirements-list">
                        <h2>Requirements</h2>
                        <ul style="margin-top: 2rem;">
                            <li>Malaysian Citizen</li>
                            <li>Enrolled as full-time university student</li>
                            <li>Physically and mentally fit</li>
                            <li>Able to commit to training schedules</li>
                            <li>Pass medical and fitness assessment</li>
                            <li>Willing to serve in the Armed Forces Reserve upon graduation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gradient-divider"></div>

    <!-- Join Us Section -->
    <section id="join" class="section join-section">
        <div class="section-content">
            <div class="two-column">
                <div class="slide-left">
                    <div class="card">
                        <h2>Join Us</h2>
                        <h3 style="margin-top: 2rem; color: #3c92d9;">How to Apply:</h3>
                        <ol style="list-style: decimal; padding-left: 2rem; margin: 1rem 0; font-size: 1.1rem;">
                            <li style="padding-left: 0;">Ensure you meet all the requirements</li>
                            <li style="padding-left: 0;">Submit Application - Follow the university's recruitment process</li>
                            <li style="padding-left: 0;">Attend Selection - Prepare your physical and mental assessments</li>
                            <li style="padding-left: 0;">Begin Your Training - Start your journey as a PALAPES cadet!</li>
                        </ol>
                        <p style="margin-top: 2rem; font-size: 1.1rem; line-height: 1.6;">
                            Ready to embark on leadership journey? Apply today to join PALAPES Laut UMS and develop the leadership skills that will benefit you for life.
                        </p>
                    </div>
                </div>
                <div class="slide-right">
                    <div class="qr-card">
                        <h3 style="margin-bottom: 1rem; color: #3c92d9;">Scan to Apply</h3>
                        <div class="qr-code">
                            <svg width="180" height="180" viewBox="0 0 180 180">
                                <!-- QR Code Pattern -->
                                <rect width="180" height="180" fill="white"/>
                                <!-- Corner squares -->
                                <rect x="10" y="10" width="50" height="50" fill="black"/>
                                <rect x="20" y="20" width="30" height="30" fill="white"/>
                                <rect x="25" y="25" width="20" height="20" fill="black"/>
                                
                                <rect x="120" y="10" width="50" height="50" fill="black"/>
                                <rect x="130" y="20" width="30" height="30" fill="white"/>
                                <rect x="135" y="25" width="20" height="20" fill="black"/>
                                
                                <rect x="10" y="120" width="50" height="50" fill="black"/>
                                <rect x="20" y="130" width="30" height="30" fill="white"/>
                                <rect x="25" y="135" width="20" height="20" fill="black"/>
                                
                                <!-- Data pattern -->
                                <rect x="70" y="10" width="5" height="5" fill="black"/>
                                <rect x="80" y="10" width="5" height="5" fill="black"/>
                                <rect x="90" y="15" width="5" height="5" fill="black"/>
                                <rect x="70" y="25" width="5" height="5" fill="black"/>
                                <rect x="85" y="30" width="5" height="5" fill="black"/>
                                <!-- Center finder -->
                                <rect x="75" y="75" width="30" height="30" fill="black"/>
                                <rect x="80" y="80" width="20" height="20" fill="white"/>
                                <rect x="85" y="85" width="10" height="10" fill="black"/>
                                
                                <!-- Additional data dots -->
                                <circle cx="40" cy="80" r="3" fill="black"/>
                                <circle cx="50" cy="90" r="3" fill="black"/>
                                <circle cx="130" cy="80" r="3" fill="black"/>
                                <circle cx="80" cy="130" r="3" fill="black"/>
                                <circle cx="140" cy="140" r="3" fill="black"/>
                                <circle cx="160" cy="120" r="3" fill="black"/>
                            </svg>
                        </div>
                        <p style="margin-top: 1rem; color: white;">Scan with your phone to access the application form</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gradient-divider-angled"></div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contact Information</h3>
                <p>📧 palapeslautums@email.com</p>
                <p>📞 +60-123-456789</p>
                <p>🏢 Universiti Malaysia Sabah</p>
                <p>Jalan UMS, 88400 Kota Kinabalu</p>
                <p>Sabah, Malaysia</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding-left: 0;"><a href="#introduction" style="color: white; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">Introduction</a></li>
                    <li style="padding-left: 0;"><a href="#about" style="color: white; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">About</a></li>
                    <li style="padding-left: 0;"><a href="#benefits" style="color: white; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">Benefits</a></li>
                    <li style="padding-left: 0;"><a href="#requirements" style="color: white; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">Requirements</a></li>
                    <li style="padding-left: 0;"><a href="#join" style="color: white; text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">Join Us</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Location</h3>
                <div class="footer-map">
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; margin-bottom: 1rem; color: #3c92d9;">📍</div>
                        <p style="color: #3c92d9; font-weight: bold;">Interactive Map</p>
                        <p>Universiti Malaysia Sabah</p>
                        <p>Campus Location</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="social-icons">
                <a href="#" class="social-icon">F</a>
                <a href="#" class="social-icon">I</a>
                <a href="#" class="social-icon">Y</a>
            </div>
            <p style="margin-top: 1rem;">&copy; 2024 PALAPES Laut UMS | Reserve Officer Training Unit</p>
        </div>
    </footer>

    <script>
        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % totalSlides);
        }

        function prevSlide() {
            showSlide((currentSlide - 1 + totalSlides) % totalSlides);
        }

        // Auto-advance carousel
        setInterval(nextSlide, 5000);

        // Manual navigation
        document.getElementById('nextBtn').addEventListener('click', nextSlide);
        document.getElementById('prevBtn').addEventListener('click', prevSlide);

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.querySelector('.carousel-container').addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.querySelector('.carousel-container').addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.getElementById('navLinks');
        
        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    navLinks.classList.remove('active');
                }
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe elements for animations
        document.querySelectorAll('.fade-in, .zoom-in, .slide-left, .slide-right').forEach(el => {
            observer.observe(el);
        });

        // Enhanced hover effects for cards
        document.querySelectorAll('.card, .benefit-card, .qr-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Initialize animations when page loads
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
            document.body.style.transition = 'opacity 1s ease-in-out';
        });
    </script>
</body>
</html>