<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - PALAPES</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        }

        /* Custom Scrollbar */
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
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            gap: 0.5rem;
            padding-right: 1rem;
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
            height: 70px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-text .main-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .nav-logo-text .sub-title {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            letter-spacing: 2px;
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
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: var(--shadow-primary);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(60, 146, 217, 0.4);
        }

        /* Main Content */
        .main-content {
            margin-top: 100px;
            min-height: calc(100vh - 100px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .success-container {
            max-width: 800px;
            width: 100%;
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 3rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
            text-align: center;
        }

        .success-header {
            margin-bottom: 2rem;
        }

        .success-icon {
            font-size: 4rem;
            color: #4caf50;
            margin-bottom: 1rem;
        }

        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 2.5rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .success-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
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
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 1rem;
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
        }

        .qr-code img {
            width: 150px;
            height: 150px;
            display: block;
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
        }

        .whatsapp-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-link i {
            margin-right: 0.5rem;
        }

        .next-steps {
            margin-top: 2rem;
            text-align: left;
        }

        .next-steps h3 {
            color: var(--primary-blue);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .next-steps ul {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .next-steps li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #4caf50;
            font-weight: bold;
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
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 8px;
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

        /* Footer Styles */
        .footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            margin-top: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: rgba(16, 20, 28, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 2rem;
                gap: 1.5rem;
                border-top: 1px solid var(--border-color);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .main-content {
                margin-top: 80px;
                padding: 1rem;
            }

            .success-container {
                padding: 2rem 1.5rem;
            }

            .qr-code-container {
                flex-direction: column;
                gap: 1rem;
            }

            .qr-code img {
                width: 120px;
                height: 120px;
            }

            .success-title {
                font-size: 2rem;
            }

            .nav-container {
                padding-right: 0;
            }
        }

        @media (max-width: 480px) {
            .success-container {
                padding: 1.5rem 1rem;
            }

            .success-title {
                font-size: 1.75rem;
            }

            .whatsapp-section {
                padding: 1.5rem;
            }

            .qr-code img {
                width: 100px;
                height: 100px;
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
                    <i class="fab fa-whatsapp" style="margin-right: 0.5rem;"></i>
                    Sertai Kumpulan WhatsApp PALAPES
                </h2>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                    Sila sertai kumpulan WhatsApp rasmi PALAPES untuk mendapatkan maklumat terkini dan komunikasi.
                </p>

                <div class="qr-code-container">
                    @if($qrCodeImage)
                        <div class="qr-code">
                            <img src="{{ asset($qrCodeImage) }}" alt="QR Code WhatsApp Group">
                        </div>
                    @else
                        <div style="color: #666; text-align: center; padding: 2rem;">
                            <i class="fas fa-qrcode" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">Kod QR akan muncul di sini apabila dimuat naik oleh pengajar</p>
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
                <i class="fas fa-home" style="margin-right: 0.5rem;"></i>
                Kembali ke Laman Utama
            </a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 ROTU NAVY UMS. Built with passion for maritime excellence.</p>
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

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 100;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    // Close mobile menu if open
                    navLinks.classList.remove('active');
                    mobileToggle.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>
