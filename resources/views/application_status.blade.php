<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Permohonan - PALAPES</title>
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

        .btn-primary {
            background: var(--primary-blue);
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.3);
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary:hover {
            background: var(--secondary-blue);
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
            padding: 1.5rem;
        }

        .status-container {
            max-width: 900px;
            width: 100%;
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
        }

        .status-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .status-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .status-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Search Form */
        .search-form {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-input {
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

        .form-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(60, 146, 217, 0.1);
            background: rgba(60, 146, 217, 0.05);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .search-btn {
            width: 100%;
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.3);
        }

        .search-btn:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
        }

        /* Results */
        .results-container {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(60, 146, 217, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(60, 146, 217, 0.3);
        }

        .applicant-info {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(60, 146, 217, 0.3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            background: rgba(60, 146, 217, 0.05);
            border-radius: 8px;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary-blue);
        }

        .info-value {
            color: var(--text-primary);
        }

        /* Evaluation Phases */
        .phases-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .phases-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .phase-card {
            padding: 1.25rem;
            background: rgba(60, 146, 217, 0.05);
            border-radius: 10px;
            border: 2px solid rgba(60, 146, 217, 0.3);
            transition: all 0.3s ease;
        }

        .phase-card.passed {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .phase-card.failed {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .phase-card.pending {
            border-color: #f59e0b;
            background: rgba(245, 158, 11, 0.1);
        }

        .phase-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .phase-name {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-primary);
        }

        .phase-status {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .phase-status.passed {
            background: #10b981;
            color: white;
        }

        .phase-status.failed {
            background: #ef4444;
            color: white;
        }

        .phase-status.pending {
            background: #f59e0b;
            color: white;
        }

        .phase-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid;
            font-weight: 500;
        }

        .alert-error {
            background: rgba(211, 47, 47, 0.1);
            border-color: rgba(211, 47, 47, 0.3);
            color: #ef5350;
        }

        .alert-info {
            background: rgba(60, 146, 217, 0.1);
            border-color: rgba(60, 146, 217, 0.3);
            color: var(--primary-blue);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem 1rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            margin-top: auto;
        }

        /* Responsive */
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

            .status-container {
                padding: 3rem;
            }

            .status-title {
                font-size: 2.5rem;
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .phases-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 767px) {
            .navbar {
                padding: 0.75rem 1rem;
            }

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

            .main-content {
                margin-top: 85px;
                padding: 1rem;
            }

            .status-container {
                padding: 2rem 1.5rem;
            }

            .status-title {
                font-size: 1.75rem;
            }

            .phase-card {
                padding: 1rem;
            }

            .phase-name {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .nav-logo img {
                height: 50px;
            }

            .nav-logo-text .main-title {
                font-size: 1.25rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.65rem;
            }

            .status-container {
                padding: 1.5rem 1rem;
            }

            .status-title {
                font-size: 1.5rem;
            }

            .info-item {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-primary {
                padding: 8px 16px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 360px) {
            .btn-primary {
                padding: 6px 12px;
                font-size: 0.75rem;
            }

            .btn-primary i {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="nav-logo">
                <img src="{{ asset('storage/assets/logo/PSS-LOGO.png') }}" alt="Logo ROTU">
                <div class="nav-logo-text">
                    <span class="main-title">PALAPES</span>
                    <span class="sub-title">LAUT UMS</span>
                </div>
            </a>
            <a href="/" class="btn-primary">
                <i class="fas fa-home" style="margin-right: 0.5rem;"></i>
                Laman Utama
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="status-container">
            <div class="status-header">
                <h1 class="status-title">Semak Status Permohonan</h1>
                <p class="status-subtitle">
                    Masukkan Nombor Matrik anda untuk menyemak status permohonan PALAPES Laut UMS
                </p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 0.5rem;"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search Form -->
            <form action="{{ route('application.status.search') }}" method="POST" class="search-form">
                @csrf
                <div class="form-group">
                    <label for="matric_no" class="form-label">
                        <i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>
                        Nombor Matrik
                    </label>
                    <input
                        type="text"
                        id="matric_no"
                        name="matric_no"
                        value="{{ old('matric_no', $matric_no ?? '') }}"
                        required
                        class="form-input"
                        placeholder="Contoh: BI22110235"
                        autocomplete="off">
                </div>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search" style="margin-right: 0.5rem;"></i>
                    Cari Status
                </button>
            </form>

            <!-- Results -->
            @if(isset($application))
                <div class="results-container">
                    <!-- Applicant Info -->
                    <div class="applicant-info">
                        <h2 style="color: var(--primary-blue); font-size: 1.5rem; margin-bottom: 1rem;">
                            <i class="fas fa-user-circle" style="margin-right: 0.5rem;"></i>
                            Maklumat Pemohon
                        </h2>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Nama:</span>
                                <span class="info-value">{{ $application->name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Nombor Matrik:</span>
                                <span class="info-value">{{ $application->matric_no }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Emel:</span>
                                <span class="info-value">{{ $application->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Jantina:</span>
                                <span class="info-value">{{ $application->gender === 'Male' ? 'Lelaki' : 'Perempuan' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fakulti:</span>
                                <span class="info-value">{{ $application->faculty }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Kursus:</span>
                                <span class="info-value">{{ $application->course }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Evaluation Phases -->
                    <h3 class="phases-title">
                        <i class="fas fa-clipboard-check" style="margin-right: 0.5rem;"></i>
                        Fasa Penilaian
                    </h3>
                    <div class="phases-grid">
                        <!-- Phase 1: Attendance -->
                        <div class="phase-card {{ $application->attendance }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">1️⃣</span>
                                    Kehadiran
                                </div>
                                <span class="phase-status {{ $application->attendance }}">
                                    @if($application->attendance === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->attendance === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Phase 2: Marching Test -->
                        <div class="phase-card {{ $application->drill_test }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">2️⃣</span>
                                    Ujian Kawad
                                </div>
                                <span class="phase-status {{ $application->drill_test }}">
                                    @if($application->drill_test === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->drill_test === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Phase 3: Physical Test -->
                        <div class="phase-card {{ $application->physical_test }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">3️⃣</span>
                                    Ujian Fizikal
                                </div>
                                <span class="phase-status {{ $application->physical_test }}">
                                    @if($application->physical_test === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->physical_test === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Phase 4: Medical Test -->
                        <div class="phase-card {{ $application->medical_test }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">4️⃣</span>
                                    Ujian Perubatan
                                </div>
                                <span class="phase-status {{ $application->medical_test }}">
                                    @if($application->medical_test === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->medical_test === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Phase 5: Interview -->
                        <div class="phase-card {{ $application->interview }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">5️⃣</span>
                                    Temuduga
                                </div>
                                <span class="phase-status {{ $application->interview }}">
                                    @if($application->interview === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->interview === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Phase 6: Final Evaluation -->
                        <div class="phase-card {{ $application->final_evaluation }}">
                            <div class="phase-header">
                                <div class="phase-name">
                                    <span class="phase-icon">6️⃣</span>
                                    Penilaian Akhir
                                </div>
                                <span class="phase-status {{ $application->final_evaluation }}">
                                    @if($application->final_evaluation === 'passed')
                                        <i class="fas fa-check-circle"></i> Lulus
                                    @elseif($application->final_evaluation === 'failed')
                                        <i class="fas fa-times-circle"></i> Gagal
                                    @else
                                        <i class="fas fa-clock"></i> Belum Dinilai
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Overall Status Message -->
                    <div class="alert alert-info" style="margin-top: 2rem;">
                        <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                        @php
                            $allPassed = $application->attendance === 'passed' &&
                                        $application->drill_test === 'passed' &&
                                        $application->physical_test === 'passed' &&
                                        $application->medical_test === 'passed' &&
                                        $application->interview === 'passed' &&
                                        $application->final_evaluation === 'passed';

                            $anyFailed = $application->attendance === 'failed' ||
                                        $application->drill_test === 'failed' ||
                                        $application->physical_test === 'failed' ||
                                        $application->medical_test === 'failed' ||
                                        $application->interview === 'failed' ||
                                        $application->final_evaluation === 'failed';
                        @endphp

                        @if($allPassed)
                            <strong>Tahniah!</strong> Anda telah lulus semua fasa pemilihan. Sila tunggu pengumuman lanjut mengenai pendaftaran akaun.
                        @elseif($anyFailed)
                            <strong>Makluman:</strong> Anda telah gagal dalam satu atau lebih fasa pemilihan. Terima kasih atas minat anda.
                        @else
                            <strong>Dalam Proses:</strong> Permohonan anda sedang dalam proses penilaian. Sila semak semula status anda dari semasa ke semasa.
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} ROTU NAVY UMS. Built with passion for maritime excellence.</p>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
