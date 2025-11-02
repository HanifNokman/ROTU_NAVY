<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - PALAPES Laut UMS</title>
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

        .btn-primary {
            background: var(--primary-blue);
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.3);
            transition: all 0.3s ease;
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
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Category Filters */
        .category-filters {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background: rgba(60, 146, 217, 0.05);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .category-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            background: rgba(60, 146, 217, 0.1);
            border: 2px solid rgba(60, 146, 217, 0.3);
            color: var(--text-primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .category-btn:hover {
            background: rgba(60, 146, 217, 0.2);
            border-color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .category-btn.active {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.3);
        }

        /* Category Section */
        .category-section {
            margin-bottom: 4rem;
        }

        .category-section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--primary-blue);
            display: flex;
            align-items: center;
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: rgba(60, 146, 217, 0.05);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(60, 146, 217, 0.3);
            border-color: var(--primary-blue);
        }

        .gallery-image-wrapper {
            position: relative;
            width: 100%;
            padding-bottom: 75%;
            overflow: hidden;
            background: var(--dark-navy);
        }

        .gallery-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-info h3 {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .gallery-info p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
        }

        .gallery-meta {
            padding: 1rem;
        }

        .gallery-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .gallery-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: var(--gradient-primary);
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.5rem;
        }

        .gallery-date {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 3000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            max-width: 90vw;
            max-height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-image {
            max-width: 100%;
            max-height: 90vh;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }

        .modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(60, 146, 217, 0.3);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: var(--primary-blue);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
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
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 1rem;
            }

            .category-filters {
                padding: 1rem;
            }

            .category-btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.85rem;
            }

            .category-section-title {
                font-size: 1.5rem;
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
                letter-spacing: 1px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .category-filters {
                gap: 0.5rem;
            }

            .category-section-title {
                font-size: 1.25rem;
                flex-wrap: wrap;
            }

            .category-section-title i {
                margin-right: 0.5rem;
            }

            .category-section-title span {
                font-size: 0.85rem;
                margin-left: 0.5rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
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
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-images" style="margin-right: 0.5rem; color: var(--primary-blue);"></i>
                    Galeri Foto
                </h1>
                <p class="page-subtitle">Koleksi foto aktiviti dan pencapaian PALAPES Laut UMS</p>
            </div>

            <!-- Category Filters -->
            <div class="category-filters">
                <button class="category-btn active" data-category="all">
                    <i class="fas fa-th" style="margin-right: 0.5rem;"></i>
                    Semua
                </button>
                @foreach($categories as $category)
                    <button class="category-btn" data-category="{{ $category->id }}">
                        <i class="fas fa-folder" style="margin-right: 0.5rem;"></i>
                        {{ $category->name }}
                        <span style="margin-left: 0.5rem; opacity: 0.7;">({{ $category->galleries->count() }})</span>
                    </button>
                @endforeach
            </div>

            <!-- Gallery Content -->
            <div id="galleryContent">
                @forelse($galleriesByCategory as $categoryId => $data)
                    <div class="category-section" data-category="{{ $categoryId }}">
                        <h2 class="category-section-title">
                            <i class="fas fa-folder" style="margin-right: 0.75rem; color: var(--primary-blue);"></i>
                            {{ $data['category']->name }}
                            <span style="font-size: 1rem; color: var(--text-secondary); font-weight: 400; margin-left: 0.75rem;">
                                ({{ $data['galleries']->count() }} foto)
                            </span>
                        </h2>
                        <div class="gallery-grid">
                            @foreach($data['galleries'] as $gallery)
                                <div class="gallery-item" data-category="{{ $gallery->gallery_category_id }}" onclick="openModal('{{ asset($gallery->image_path) }}', '{{ addslashes($gallery->title) }}')">
                                    <div class="gallery-image-wrapper">
                                        <img src="{{ asset($gallery->image_path) }}" alt="{{ $gallery->title }}" class="gallery-image" loading="lazy" onerror="this.src='{{ asset('storage/assets/placeholder.jpg') }}'">
                                        <div class="gallery-overlay">
                                            <div class="gallery-info">
                                                <h3>{{ $gallery->title }}</h3>
                                                @if($gallery->description)
                                                    <p>{{ Str::limit($gallery->description, 100) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gallery-meta">
                                        <div class="gallery-category">{{ $gallery->category->name }}</div>
                                        <div class="gallery-title">{{ $gallery->title }}</div>
                                        <div class="gallery-date">
                                            <i class="far fa-calendar" style="margin-right: 0.25rem;"></i>
                                            {{ $gallery->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-images"></i>
                        <h3 style="margin-bottom: 0.5rem;">Tiada foto dijumpai</h3>
                        <p>Galeri masih kosong. Sila semak semula kemudian.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <img id="modalImage" class="modal-image" src="" alt="">
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 ROTU NAVY UMS. Built with passion for maritime excellence.</p>
    </footer>

    <script>
        // Category filtering
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.dataset.category;

                // Update active button
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Filter category sections
                const sections = document.querySelectorAll('.category-section');
                sections.forEach(section => {
                    if (category === 'all' || section.dataset.category == category) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        });

        // Modal functions
        function openModal(imageSrc, title) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageSrc;
            modalImage.alt = title;
            modal.classList.add('active');

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');

            // Restore body scroll
            document.body.style.overflow = '';
        }

        // Close modal on background click
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

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
