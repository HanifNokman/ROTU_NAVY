<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - PALAPES</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--darker-navy);
            color: var(--text-primary);
            line-height: 1.7;
            min-height: 100vh;
            overflow-x: hidden;
        }

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

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(16, 20, 28, 0.95);
            backdrop-filter: blur(20px);
            padding: 0.75rem 1rem;
            z-index: 2000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar.scrolled {
            background: rgba(16, 20, 28, 0.98);
            box-shadow: 0 4px 32px rgba(0, 0, 0, 0.3);
            padding: 0.5rem 1rem;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            gap: 0.5rem;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .nav-logo:hover {
            transform: scale(1.02);
        }

        .nav-logo img {
            width: auto;
            height: 60px;
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
            letter-spacing: 1.5px;
            text-transform: uppercase;
            line-height: 1;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            color: var(--text-primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-blue);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: var(--shadow-primary);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(60, 146, 217, 0.4);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 8px;
            flex-shrink: 0;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 2px;
            background: var(--text-primary);
            margin: 3px 0;
            transition: 0.3s;
            border-radius: 1px;
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        /* Main Content */
        .main-content {
            margin-top: 90px;
            min-height: calc(100vh - 90px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .success-container {
            max-width: 800px;
            width: 100%;
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
            text-align: center;
        }

        .success-header {
            margin-bottom: 2rem;
        }

        .success-icon {
            font-size: 3.5rem;
            color: #4caf50;
            margin-bottom: 1rem;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .success-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .whatsapp-section {
            background: rgba(60, 146, 217, 0.1);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(60, 146, 217, 0.2);
        }

        .whatsapp-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        .whatsapp-title i {
            margin-right: 0.5rem;
            color: #25d366;
        }

        .qr-code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .qr-code {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
            display: block;
        }

        .qr-placeholder {
            color: #666;
            text-align: center;
            padding: 2rem 1rem;
        }

        .qr-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
            display: block;
        }

        .qr-placeholder p {
            margin: 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .whatsapp-link {
            display: inline-block;
            background: #25d366;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            font-size: 1rem;
        }

        .whatsapp-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
            background: #20ba5a;
        }

        .whatsapp-link i {
            margin-right: 0.5rem;
        }

        .next-steps {
            margin-top: 2rem;
            text-align: left;
            background: rgba(60, 146, 217, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
        }

        .next-steps h3 {
            color: var(--primary-blue);
            font-size: 1.15rem;
            margin-bottom: 1rem;
        }

        .next-steps ul {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
            padding-left: 1.75rem;
            position: relative;
            line-height: 1.5;
        }

        .next-steps li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4caf50;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .btn-back {
            display: inline-block;
            margin-top: 2rem;
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-primary);
            font-size: 1rem;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
        }

        .btn-back i {
            margin-right: 0.5rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem 1rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            margin-top: auto;
        }

        /* Tablet and Desktop */
        @media (min-width: 768px) {
            .navbar {
                padding: 1rem 2rem;
            }

            .nav-logo img {
                height: 70px;
            }

            .nav-logo-text .main-title {
                font-size: 1.75rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.875rem;
                letter-spacing: 2px;
            }

            .main-content {
                margin-top: 100px;
                padding: 2rem;
            }

            .success-container {
                padding: 3rem;
            }

            .success-icon {
                font-size: 4rem;
            }

            .success-title {
                font-size: 2.5rem;
            }

            .success-subtitle {
                font-size: 1.1rem;
            }

            .whatsapp-title {
                font-size: 1.5rem;
            }

            .qr-code img {
                width: 180px;
                height: 180px;
            }

            .next-steps h3 {
                font-size: 1.25rem;
            }
        }

        /* Mobile Navigation */
        @media (max-width: 767px) {
            .nav-links {
                display: none;
                position: fixed;
                top: 77px;
                left: 0;
                width: 100%;
                max-height: calc(100vh - 77px);
                background: rgba(16, 20, 28, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 2rem 1rem;
                gap: 0;
                border-top: 1px solid var(--border-color);
                overflow-y: auto;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .nav-links a {
                font-size: 1rem;
                padding: 0.75rem 1rem;
                width: 100%;
                display: block;
                text-align: center;
                background: rgba(60, 146, 217, 0.05);
                border-radius: 8px;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .main-content {
                margin-top: 85px;
                padding: 1rem;
            }

            .success-container {
                padding: 2rem 1.5rem;
            }

            .whatsapp-section {
                padding: 1.5rem;
            }

            .qr-code img {
                width: 130px;
                height: 130px;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .nav-logo img {
                height: 50px;
            }

            .nav-logo-text .main-title {
                font-size: 1.25rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.65rem;
                letter-spacing: 1px;
            }

            .success-container {
                padding: 1.5rem 1rem;
            }

            .success-icon {
                font-size: 3rem;
            }

            .success-title {
                font-size: 1.5rem;
            }

            .success-subtitle {
                font-size: 0.95rem;
            }

            .whatsapp-section {
                padding: 1.25rem 1rem;
            }

            .whatsapp-title {
                font-size: 1.15rem;
            }

            .qr-code {
                padding: 0.75rem;
            }

            .qr-code img {
                width: 110px;
                height: 110px;
            }

            .whatsapp-link {
                padding: 0.875rem 1.5rem;
                font-size: 0.95rem;
            }

            .next-steps {
                padding: 1.25rem 1rem;
            }

            .next-steps h3 {
                font-size: 1.05rem;
            }

            .next-steps li {
                font-size: 0.9rem;
                padding-left: 1.5rem;
                margin-bottom: 0.65rem;
            }

            .btn-back {
                padding: 0.875rem 1.5rem;
                font-size: 0.95rem;
            }

            .btn-primary {
                padding: 8px 20px;
                font-size: 0.85rem;
            }
        }

        /* Very Small Screens */
        @media (max-width: 360px) {
            .main-content {
                padding: 0.75rem;
            }

            .success-container {
                padding: 1.25rem 0.875rem;
            }

            .qr-code img {
                width: 100px;
                height: 100px;
            }

            .whatsapp-link {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }
        }

        /* Landscape Mode */
        @media (max-height: 500px) and (orientation: landscape) {
            .navbar {
                padding: 0.5rem 1rem;
            }

            .nav-logo img {
                height: 40px;
            }

            .main-content {
                margin-top: 70px;
                padding: 1rem;
            }

            .success-container {
                padding: 1.5rem;
            }

            .success-icon {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }

            .success-header {
                margin-bottom: 1.5rem;
            }

            .whatsapp-section {
                padding: 1.25rem;
                margin: 1.5rem 0;
            }

            .qr-code img {
                width: 100px;
                height: 100px;
            }

            .next-steps {
                margin-top: 1.5rem;
                padding: 1.25rem;
            }

            .btn-back {
                margin-top: 1.5rem;
                padding: 0.75rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="nav-logo">
                <img src="storage/assets/logo/PSS-LOGO.png" alt="Logo ROTU">
                <div class="nav-logo-text">
                    <span class="main-title">PALAPES</span>
                    <span class="sub-title">LAUT UMS</span>
                </div>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="/">Laman Utama</a></li>
                <li><a href="/#introduction">Pengenalan</a></li>
                <li><a href="/#timeline">Perjalanan</a></li>
                <li><a href="/#about">Mengenai</a></li>
                <li><a href="/#benefits">Faedah</a></li>
                <li><a href="/#requirements">Syarat</a></li>
                <li><a href="/#selection">Pemilihan</a></li>
                <li><a href="/#application">Mohon</a></li>
            </ul>

            <div class="mobile-menu-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="success-container">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="success-title">Permohonan Berjaya Dihantar!</h1>
                <p class="success-subtitle">
                    Terima kasih atas minat anda untuk menyertai PALAPES Laut UMS. Permohonan anda telah berjaya dihantar dan akan diproses dalam masa terdekat.
                </p>
            </div>

            <div class="whatsapp-section">
                <h2 class="whatsapp-title">
                    <i class="fab fa-whatsapp"></i>
                    Sertai Kumpulan WhatsApp PALAPES
                </h2>
                <p style="color: var(--text-secondary); margin-bottom: 1rem; font-size: 0.95rem;">
                    Sila sertai kumpulan WhatsApp rasmi PALAPES untuk mendapatkan maklumat terkini dan komunikasi.
                </p>

                <div class="qr-code-container">
                    @if($qrCodeImage)
                        <div class="qr-code">
                            <img src="{{ asset($qrCodeImage) }}" alt="QR Code WhatsApp Group">
                        </div>
                    @else
                        <div class="qr-placeholder">
                            <i class="fas fa-qrcode"></i>
                            <p>Kod QR akan muncul di sini apabila dimuat naik oleh pengajar</p>
                        </div>
                    @endif

                    @if($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" class="whatsapp-link">
                            <i class="fab fa-whatsapp"></i>
                            Sertai Kumpulan WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            <div class="next-steps">
                <h3>Langkah Seterusnya:</h3>
                <ul>
                    <li>Sertai kumpulan WhatsApp untuk maklumat terkini</li>
                    @if($applicationDeadline)
                        <li>Tarikh pemilihan: <strong>{{ $applicationDeadline }}</strong></li>
                    @endif
                    <li>Pemakaian: Baju sukan lengkap</li>
                    <li>Sediakan dokumen yang diperlukan untuk verifikasi</li>
                </ul>
            </div>

            <a href="/" class="btn-back">
                <i class="fas fa-home"></i>
                Kembali ke Laman Utama
            </a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} ROTU NAVY UMS. Built with passion for maritime excellence.</p>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.getElementById('navLinks');

        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                mobileToggle.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const navbarHeight = document.getElementById('navbar').offsetHeight;
                        const offsetTop = target.offsetTop - navbarHeight;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        navLinks.classList.remove('active');
                        mobileToggle.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            });
        });
    </script>
</body>
</html>