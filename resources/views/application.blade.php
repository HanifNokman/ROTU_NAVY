<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join PALAPES - Application Form</title>
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

        .application-container {
            max-width: 1200px;
            width: 100%;
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
        }

        .application-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .application-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .application-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Form Styles */
        .application-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-label i {
            margin-right: 0.5rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            border: 2px solid rgba(60, 146, 217, 0.3);
            background: rgba(60, 146, 217, 0.1);
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-select option {
            background: var(--darker-navy);
            color: var(--text-primary);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(60, 146, 217, 0.1);
            background: rgba(60, 146, 217, 0.05);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-file {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 8px;
            border: 2px solid rgba(60, 146, 217, 0.3);
            background: rgba(60, 146, 217, 0.1);
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form-file:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(60, 146, 217, 0.1);
        }

        .form-file::-webkit-file-upload-button {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-file::-webkit-file-upload-button:hover {
            background: var(--secondary-blue);
            transform: translateY(-1px);
        }

        .form-help {
            display: block;
            margin-top: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border: 1px solid;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(46, 125, 50, 0.1);
            border-color: rgba(46, 125, 50, 0.3);
            color: #81c784;
        }

        .alert-error {
            background: rgba(211, 47, 47, 0.1);
            border-color: rgba(211, 47, 47, 0.3);
            color: #ef5350;
        }

        .alert ul {
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            box-shadow: var(--shadow-primary);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Form Row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 0;
        }

        .form-row .form-group {
            margin-bottom: 1.5rem;
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

            .application-container {
                padding: 3rem;
            }

            .application-title {
                font-size: 2.5rem;
            }

            .application-subtitle {
                font-size: 1.1rem;
            }

            .form-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .form-row .form-group {
                margin-bottom: 0;
            }

            .form-input,
            .form-select,
            .form-textarea {
                font-size: 1rem;
            }

            .form-label {
                font-size: 0.95rem;
            }

            .form-help {
                font-size: 0.875rem;
            }

            .submit-btn {
                font-size: 1.1rem;
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

            .application-container {
                padding: 2rem 1.5rem;
            }

            .application-title {
                font-size: 1.75rem;
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

            .application-container {
                padding: 1.5rem 1rem;
            }

            .application-title {
                font-size: 1.5rem;
            }

            .application-subtitle {
                font-size: 0.95rem;
            }

            .form-input,
            .form-select,
            .form-textarea,
            .form-file {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .form-file::-webkit-file-upload-button {
                padding: 0.4rem 0.75rem;
                margin-right: 0.75rem;
                font-size: 0.85rem;
            }

            .submit-btn {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
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

            .application-container {
                padding: 1.25rem 1rem;
            }

            .form-label {
                font-size: 0.85rem;
            }

            .form-help {
                font-size: 0.8rem;
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

            .application-container {
                padding: 1.5rem;
            }

            .application-header {
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .submit-btn {
                margin-top: 1.5rem;
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
        <div class="application-container">
            @if($applicationDeadline && now() > $applicationDeadline)
                <div class="alert alert-error" style="text-align: center; padding: 2.5rem 2rem;">
                    <i class="fas fa-clock" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.7;"></i>
                    <h2 style="color: var(--text-primary); margin-bottom: 1rem; font-size: 1.5rem;">Permohonan Ditutup</h2>
                    <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem;">
                        Tarikh akhir permohonan telah berlalu pada <strong>{{ $applicationDeadline->format('d F Y') }}</strong>.
                        Sila tunggu pengumuman sesi permohonan seterusnya.
                    </p>
                    <a href="/" class="btn-primary">
                        <i class="fas fa-home" style="margin-right: 0.5rem;"></i>
                        Kembali ke Laman Utama
                    </a>
                </div>
            @else
                <div class="application-header">
                    <h1 class="application-title">Mohon Sertai PALAPES Laut UMS</h1>
                    <p class="application-subtitle">
                        Ambil langkah pertama ke arah menjadi pegawai tentera laut yang ditauliahkan. Isi borang permohonan di bawah dengan maklumat yang tepat.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
                        Sila betulkan ralat berikut:
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('application.store') }}" method="POST" enctype="multipart/form-data" class="application-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i>Nama Penuh
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="form-input" placeholder="Masukkan nama penuh anda">
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i>Alamat Emel
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="form-input" placeholder="contoh@email.com">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone_number" class="form-label">
                                <i class="fas fa-phone"></i>Nombor Telefon
                            </label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                class="form-input" placeholder="012-3456789">
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-label">
                                <i class="fas fa-venus-mars"></i>Jantina
                            </label>
                            <select id="gender" name="gender" required class="form-select">
                                <option value="">Pilih Jantina</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Lelaki</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ic_number" class="form-label">
                                <i class="fas fa-id-card"></i>Nombor Kad Pengenalan
                            </label>
                            <input type="text" id="ic_number" name="ic_number" value="{{ old('ic_number') }}" required
                                class="form-input" placeholder="000000-00-0000">
                        </div>

                        <div class="form-group">
                            <label for="matric_no" class="form-label">
                                <i class="fas fa-graduation-cap"></i>Nombor Matrik
                            </label>
                            <input type="text" id="matric_no" name="matric_no" value="{{ old('matric_no') }}" required
                                class="form-input" placeholder="Masukkan nombor matrik UMS">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="faculty" class="form-label">
                                <i class="fas fa-university"></i>Fakulti
                            </label>
                            <select id="faculty" name="faculty" required class="form-select">
                                <option value="">Pilih Fakulti</option>
                                <option value="FKJ" {{ old('faculty') == 'FKJ' ? 'selected' : '' }}>Fakulti Kejuruteraan (FKJ)</option>
                                <option value="FSMP" {{ old('faculty') == 'FSMP' ? 'selected' : '' }}>Fakulti Sains Makanan & Pemakanan (FSMP)</option>
                                <option value="FPEP" {{ old('faculty') == 'FPEP' ? 'selected' : '' }}>Fakulti Perniagaan, Ekonomi & Perakaunan (FPEP)</option>
                                <option value="FKI" {{ old('faculty') == 'FKI' ? 'selected' : '' }}>Fakulti Komputeran & Informatik (FKI)</option>
                                <option value="FSSK" {{ old('faculty') == 'FSSK' ? 'selected' : '' }}>Fakulti Sains Sosial & Kemanusiaan (FSSK)</option>
                                <option value="FPKS" {{ old('faculty') == 'FPKS' ? 'selected' : '' }}>Fakulti Psikologi & Kerja Sosial (FPKS)</option>
                                <option value="FPPS" {{ old('faculty') == 'FPPS' ? 'selected' : '' }}>Fakulti Pendidikan & Pengurusan Sukan (FPPS)</option>
                                <option value="FST" {{ old('faculty') == 'FST' ? 'selected' : '' }}>Fakulti Sains & Teknologi (FST)</option>
                                <option value="FPT" {{ old('faculty') == 'FPT' ? 'selected' : '' }}>Fakulti Perhutanan Tropika (FPT)</option>
                                <option value="FPI" {{ old('faculty') == 'FPI' ? 'selected' : '' }}>Fakulti Pengajian Islam (FPI)</option>
                                <option value="ASTiF" {{ old('faculty') == 'ASTiF' ? 'selected' : '' }}>Akademi Seni & Teknologi Kreatif (ASTiF)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course" class="form-label">
                                <i class="fas fa-book"></i>Kursus
                            </label>
                            <input type="text" id="course" name="course" value="{{ old('course') }}" required
                                class="form-input" placeholder="Masukkan nama kursus">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="height" class="form-label">
                                <i class="fas fa-ruler-vertical"></i>Tinggi (cm)
                            </label>
                            <input type="number" id="height" name="height" value="{{ old('height') }}" step="0.01" min="100" max="250"
                                class="form-input" placeholder="Contoh: 170.5">
                            <span class="form-help">
                                <i class="fas fa-info-circle"></i>
                                Masukkan tinggi dalam sentimeter (cm)
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="weight" class="form-label">
                                <i class="fas fa-weight"></i>Berat (kg)
                            </label>
                            <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="30" max="200"
                                class="form-input" placeholder="Contoh: 65.5">
                            <span class="form-help">
                                <i class="fas fa-info-circle"></i>
                                Masukkan berat dalam kilogram (kg)
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bmi" class="form-label">
                            <i class="fas fa-calculator"></i>BMI (Kiraan Automatik)
                        </label>
                        <input type="number" id="bmi" name="bmi" value="{{ old('bmi') }}" step="0.01" readonly
                            class="form-input" placeholder="BMI akan dikira secara automatik">
                        <span class="form-help">
                            <i class="fas fa-info-circle"></i>
                            BMI akan dikira secara automatik berdasarkan tinggi dan berat yang dimasukkan
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="profile_pic" class="form-label">
                            <i class="fas fa-camera"></i>Gambar Profil
                        </label>
                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*"
                            class="form-file">
                        <span class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Muat naik gambar passport terkini (JPEG, PNG, JPG, GIF - Maksimum 2MB)
                        </span>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i>
                        Hantar Permohonan
                    </button>
                </form>
            @endif
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

        // BMI Calculator
        function calculateBMI() {
            const height = parseFloat(document.getElementById('height').value);
            const weight = parseFloat(document.getElementById('weight').value);
            const bmiField = document.getElementById('bmi');

            if (height > 0 && weight > 0) {
                const heightInMeters = height / 100;
                const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
                bmiField.value = bmi;
            } else {
                bmiField.value = '';
            }
        }

        // Add event listeners for height and weight inputs
        document.getElementById('height').addEventListener('input', calculateBMI);
        document.getElementById('weight').addEventListener('input', calculateBMI);

        // Calculate BMI on page load if values exist
        window.addEventListener('load', calculateBMI);

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