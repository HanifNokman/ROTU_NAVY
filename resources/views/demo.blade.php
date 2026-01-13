<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Demo - ROTU NAVY UMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            background: linear-gradient(135deg, var(--darker-navy) 0%, var(--dark-navy) 100%);
            color: var(--text-primary);
            line-height: 1.5;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .home-button {
            position: absolute;
            left: 0;
            top: 0;
            background: var(--gradient-primary);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-primary);
        }

        .home-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(60, 146, 217, 0.4);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* System Highlights Section */
        .highlights-section {
            margin-bottom: 2rem;
        }

        .highlights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .highlight-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.25rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .highlight-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .highlight-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-primary);
            border-color: var(--primary-blue);
        }

        .highlight-card:hover::before {
            transform: scaleX(1);
        }

        .highlight-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 0.75rem;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .highlight-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.4rem;
            color: var(--text-primary);
        }

        .highlight-card p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .highlight-number {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.4rem;
        }

        .features-overview {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.5rem;
        }

        .features-overview h3 {
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
            text-align: center;
            color: var(--primary-blue);
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 0.75rem;
        }

        .feature-badge {
            background: rgba(60, 146, 217, 0.1);
            border: 1px solid rgba(60, 146, 217, 0.3);
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
        }

        .feature-badge:hover {
            background: rgba(60, 146, 217, 0.2);
            border-color: var(--primary-blue);
            transform: translateX(5px);
        }

        .feature-badge i {
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .feature-badge span {
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        /* Video Section */
        .video-section {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .video-section h2 {
            color: var(--primary-blue);
            margin-bottom: 1.25rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 16/9;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            display: block;
        }

        .video-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-secondary);
            gap: 1rem;
        }

        .video-placeholder i {
            font-size: 4rem;
            color: var(--primary-blue);
        }

        .video-placeholder p {
            font-size: 1.1rem;
        }

        /* Sitemap Section */
        .sitemap-intro {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .sitemap-intro h2 {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sitemap-intro p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        /* Landing Page Box */
        .landing-box {
            background: var(--gradient-primary);
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-primary);
        }

        .landing-box h3 {
            font-size: 1.5rem;
            margin-bottom: 0.4rem;
        }

        .landing-box p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        /* Branch Container */
        .branches-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Access Card */
        .access-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .access-card:hover {
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-primary);
        }

        .access-card.guest { border-top: 3px solid #10b981; }
        .access-card.instructor { border-top: 3px solid var(--primary-blue); }
        .access-card.cadet { border-top: 3px solid var(--accent-pink); }
        .access-card.admin { border-top: 3px solid #f59e0b; }

        .access-header {
            padding: 1.1rem 1.3rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.03);
        }

        .access-header:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .access-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .access-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .guest .access-icon { background: linear-gradient(135deg, #10b981, #059669); }
        .instructor .access-icon { background: var(--gradient-primary); }
        .cadet .access-icon { background: linear-gradient(135deg, #ec6c6c, #e74c3c); }
        .admin .access-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .access-title h3 {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .access-title p {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .toggle-icon {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
            color: var(--primary-blue);
        }

        .toggle-icon.active {
            transform: rotate(180deg);
        }

        .access-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            opacity: 0;
            visibility: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease, visibility 0.3s ease;
        }

        .access-content.active {
            max-height: 5000px;
            opacity: 1;
            visibility: visible;
        }

        .access-body {
            padding: 1.25rem;
        }

        /* Feature Section */
        .feature-section {
            margin-bottom: 1rem;
        }

        .feature-header {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.75rem 0.9rem;
            background: rgba(60, 146, 217, 0.1);
            border-left: 3px solid var(--primary-blue);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 0.4rem;
        }

        .feature-header:hover {
            background: rgba(60, 146, 217, 0.15);
        }

        .feature-header i {
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .feature-header h4 {
            font-size: 1rem;
            font-weight: 600;
            flex: 1;
        }

        .feature-items {
            padding-left: 2rem;
            margin-top: 0.4rem;
        }

        .feature-item {
            padding: 0.6rem;
            margin-bottom: 0.4rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 6px;
            border-left: 2px solid rgba(60, 146, 217, 0.3);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.06);
            border-left-color: var(--primary-blue);
            transform: translateX(5px);
        }

        .feature-item strong {
            color: var(--primary-blue);
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.925rem;
        }

        .feature-subitem {
            padding-left: 0.85rem;
            margin: 0.2rem 0;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .feature-subitem::before {
            content: "→";
            color: var(--primary-blue);
            margin-right: 0.4rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem;
            margin-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .footer p {
            font-size: 0.9rem;
        }

        /* Video Upload Section */
        .video-upload-section {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(60, 146, 217, 0.1);
            border: 2px dashed var(--primary-blue);
            border-radius: 12px;
            text-align: center;
        }

        .upload-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .upload-btn {
            background: var(--gradient-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }

        .file-input {
            display: none;
        }

        .upload-info {
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .upload-progress {
            margin-top: 1rem;
            display: none;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--gradient-primary);
            width: 0%;
            transition: width 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .home-button {
                position: static;
                display: inline-flex;
                margin-bottom: 1rem;
            }

            .branches-container {
                grid-template-columns: 1fr;
            }

            .access-title h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="{{ route('landing') }}" class="home-button">
                <i class="fas fa-home"></i>
                <span>Back to Home</span>
            </a>
            <h1>System Demo</h1>
            <p>Interactive system demonstration for ROTU NAVY UMS</p>
        </div>

        <!-- System Highlights Section -->
        <div class="highlights-section">
            <div class="highlights-grid">
                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="highlight-number">4</div>
                    <h3>Access Levels</h3>
                    <p>Guest, Cadet, Instructor, and Admin roles with tailored features</p>
                </div>

                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <div class="highlight-number">50+</div>
                    <h3>Features</h3>
                    <p>Comprehensive modules covering training, inventory, learning, and more</p>
                </div>

                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="highlight-number">GPS</div>
                    <h3>Geofencing</h3>
                    <p>Location-based attendance verification and tracking system</p>
                </div>

                <div class="highlight-card">
                    <div class="highlight-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="highlight-number">∞</div>
                    <h3>Gamification</h3>
                    <p>Badge system, leaderboards, and performance tracking</p>
                </div>
            </div>

            <div class="features-overview">
                <h3><i class="fas fa-star"></i> Key System Capabilities</h3>

                <!-- Instructor Features -->
                <h4 style="color: var(--primary-blue); font-size: 1.1rem; margin-top: 1.5rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-tie"></i>
                    Instructor Features
                </h4>
                <div class="features-list">
                    <div class="feature-badge">
                        <i class="fas fa-user-check"></i>
                        <span>Application Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-users-cog"></i>
                        <span>Cadet Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-dumbbell"></i>
                        <span>Training Scheduler</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-boxes"></i>
                        <span>Inventory System</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-tshirt"></i>
                        <span>Uniform Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-book"></i>
                        <span>Learning Hub Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-question-circle"></i>
                        <span>Quiz Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-chart-line"></i>
                        <span>Performance Analytics</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Allowance Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-file-export"></i>
                        <span>Report Generation</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-camera"></i>
                        <span>Gallery Management</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-medal"></i>
                        <span>Badge Management</span>
                    </div>
                </div>

                <!-- Cadet Features -->
                <h4 style="color: var(--accent-pink); font-size: 1.1rem; margin-top: 1.5rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-graduate"></i>
                    Cadet Features
                </h4>
                <div class="features-list">
                    <div class="feature-badge">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Attendance Tracking</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-book-open"></i>
                        <span>Learning Hub</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-brain"></i>
                        <span>Quiz System</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-trophy"></i>
                        <span>Performance Tracking</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-money-bill"></i>
                        <span>Allowance Tracking</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-medal"></i>
                        <span>Badge Collection</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-box"></i>
                        <span>Uniform Profile</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-tools"></i>
                        <span>Equipment Loans</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-images"></i>
                        <span>Gallery Access</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </div>
                </div>

                <!-- Shared Features -->
                <h4 style="color: #10b981; font-size: 1.1rem; margin-top: 1.5rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-cogs"></i>
                    System Features
                </h4>
                <div class="features-list">
                    <div class="feature-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Role-Based Access</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>GPS Geofencing</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-gamepad"></i>
                        <span>Gamification</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Responsive Design</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Objective Section -->
        <div class="features-overview">
            <h3><i class="fas fa-bullseye"></i> System Objectives</h3>
            <div class="feature-items">
                <div class="feature-item">
                    <i class="fas fa-database" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Manage PALAPES Laut UMS information and content in a centralized manner</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-share-alt" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Facilitate information delivery to instructors and cadets</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-laptop-code" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Provide a digital learning platform to support cadet training</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-user-plus" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Attract students' interest in joining PALAPES Laut UMS</span>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-section" style="margin-top: 2rem;">
            <h2>
                <i class="fas fa-video"></i>
                System Demo Video (15 minutes)
            </h2>
            <div class="video-container" id="videoContainer">
                @if(isset($videoPath) && $videoPath)
                    <video controls id="demoVideo">
                        <source src="{{ $videoPath }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="video-placeholder">
                        <i class="fas fa-film"></i>
                        <p>Video demo will be displayed here</p>
                        @auth
                            @if(in_array(auth()->user()->role, ['instructor', 'admin']))
                                <p style="font-size: 0.9rem; opacity: 0.7;">Use the upload button below to add your demo video</p>
                            @else
                                <p style="font-size: 0.9rem; opacity: 0.7;">System demo video will be available soon</p>
                            @endauth
                        @else
                            <p style="font-size: 0.9rem; opacity: 0.7;">System demo video will be available soon</p>
                        @endauth
                    </div>
                @endif
            </div>

            @auth
                @if(in_array(auth()->user()->role, ['instructor', 'admin']))
                    <div class="video-upload-section">
                        <div class="upload-controls">
                            <button class="upload-btn" onclick="document.getElementById('videoFile').click()">
                                <i class="fas fa-upload"></i>
                                <span>{{ isset($videoPath) && $videoPath ? 'Replace Video' : 'Upload Video' }}</span>
                            </button>
                            <input type="file" id="videoFile" class="file-input" accept="video/mp4,video/mov,video/avi,video/wmv">

                            @if(isset($videoPath) && $videoPath)
                                <button class="delete-btn" onclick="deleteVideo()">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete Video</span>
                                </button>
                            @endif
                        </div>
                        <div class="upload-info">
                            <i class="fas fa-info-circle"></i>
                            Maximum file size: 500MB | Supported formats: MP4, MOV, AVI, WMV
                        </div>
                        <div class="upload-progress" id="uploadProgress">
                            <div class="progress-bar">
                                <div class="progress-fill" id="progressFill"></div>
                            </div>
                            <p id="progressText" style="margin-top: 0.5rem; font-size: 0.9rem;">Uploading... 0%</p>
                        </div>
                    </div>
                @endif
            @endauth
        </div>

        <!-- System Map Introduction -->
        <div class="sitemap-intro">
            <h2>Interactive System Map</h2>
            <p>Explore the complete structure and features of the ROTU NAVY system</p>
        </div>

        <!-- Landing Page -->
        <div class="landing-box">
            <h3><i class="fas fa-home"></i> Landing Page</h3>
            <p>Main entry point for all users - branches into 4 access levels</p>
        </div>

        <!-- Access Level Branches -->
        <div class="branches-container">
            <!-- Guest Access -->
            <div class="access-card guest">
                <div class="access-header" onclick="toggleAccess('guest')">
                    <div class="access-title">
                        <div class="access-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3>Guest Access</h3>
                            <p>Public Features</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon" id="guest-toggle"></i>
                </div>
                <div class="access-content" id="guest-content">
                    <div class="access-body">
                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-file-alt"></i>
                                <h4>Application Pages</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <strong>Create Application</strong>
                                    <div class="feature-subitem">Submit new cadet application</div>
                                    <div class="feature-subitem">Fill out personal information</div>
                                    <div class="feature-subitem">Upload required documents</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Application Status</strong>
                                    <div class="feature-subitem">Check application status</div>
                                    <div class="feature-subitem">Search by application ID</div>
                                    <div class="feature-subitem">Track application progress</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-images"></i>
                                <h4>Public Gallery</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View public photo galleries</div>
                                    <div class="feature-subitem">Browse by category</div>
                                    <div class="feature-subitem">View training activities and events</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-info-circle"></i>
                                <h4>About Page</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Information about the system</div>
                                    <div class="feature-subitem">Program details</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructor Access -->
            <div class="access-card instructor">
                <div class="access-header" onclick="toggleAccess('instructor')">
                    <div class="access-title">
                        <div class="access-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h3>Instructor Access</h3>
                            <p>Administrative Features</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon" id="instructor-toggle"></i>
                </div>
                <div class="access-content" id="instructor-content">
                    <div class="access-body">
                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-tachometer-alt"></i>
                                <h4>Instructor Dashboard</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Overview of system statistics</div>
                                    <div class="feature-subitem">Quick access to key features</div>
                                    <div class="feature-subitem">Duty increment tracking</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-user-clock"></i>
                                <h4>Pending Verification</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Review new applications</div>
                                    <div class="feature-subitem">Accept/reject applicants</div>
                                    <div class="feature-subitem">Bulk actions</div>
                                    <div class="feature-subitem">Selection process management</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-user-graduate"></i>
                                <h4>Cadet Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View all cadets</div>
                                    <div class="feature-subitem">Individual cadet profiles</div>
                                    <div class="feature-subitem">Position management</div>
                                    <div class="feature-subitem">Rank promotion</div>
                                    <div class="feature-subitem">Swimming qualification tracking</div>
                                    <div class="feature-subitem">Suspend/reactivate cadets</div>
                                    <div class="feature-subitem">Best cadet/academic awards</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-dumbbell"></i>
                                <h4>Training Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Create/edit training sessions</div>
                                    <div class="feature-subitem">Set geofencing boundaries for locations</div>
                                    <div class="feature-subitem">Record attendance (manual/GPS)</div>
                                    <div class="feature-subitem">View attendance reports</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-money-bill-wave"></i>
                                <h4>Allowance Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View cadet allowances</div>
                                    <div class="feature-subitem">Track training-based payments</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-boxes"></i>
                                <h4>Inventory Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <strong>Uniform Management</strong>
                                    <div class="feature-subitem">Create/delete uniform types</div>
                                    <div class="feature-subitem">Manage components</div>
                                    <div class="feature-subitem">Track sizes</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Equipment Management</strong>
                                    <div class="feature-subitem">Add/remove equipment</div>
                                    <div class="feature-subitem">Track equipment loans</div>
                                    <div class="feature-subitem">Update loan status</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Export Options</strong>
                                    <div class="feature-subitem">Export uniform sizes</div>
                                    <div class="feature-subitem">Export equipment loans</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-book"></i>
                                <h4>Learning Hub Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <strong>Learning Materials</strong>
                                    <div class="feature-subitem">Create/edit/delete materials</div>
                                    <div class="feature-subitem">Upload PDFs, videos, links</div>
                                    <div class="feature-subitem">Set difficulty levels</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Quiz Management</strong>
                                    <div class="feature-subitem">Create quiz questions</div>
                                    <div class="feature-subitem">Edit/delete questions</div>
                                    <div class="feature-subitem">Multiple choice format</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-camera"></i>
                                <h4>Gallery Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Upload photos</div>
                                    <div class="feature-subitem">Create/delete categories</div>
                                    <div class="feature-subitem">Organize by events</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-chart-bar"></i>
                                <h4>Reports & Analytics</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Training reports</div>
                                    <div class="feature-subitem">Attendance reports</div>
                                    <div class="feature-subitem">Inventory reports</div>
                                    <div class="feature-subitem">Performance reports</div>
                                    <div class="feature-subitem">Financial reports</div>
                                    <div class="feature-subitem">Analytics dashboard</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cadet Access -->
            <div class="access-card cadet">
                <div class="access-header" onclick="toggleAccess('cadet')">
                    <div class="access-title">
                        <div class="access-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h3>Cadet Access</h3>
                            <p>Student Features</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon" id="cadet-toggle"></i>
                </div>
                <div class="access-content" id="cadet-content">
                    <div class="access-body">
                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-home"></i>
                                <h4>Cadet Dashboard</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Personal statistics overview</div>
                                    <div class="feature-subitem">Rank and position display</div>
                                    <div class="feature-subitem">Recent activities</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-dumbbell"></i>
                                <h4>Training</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View upcoming training sessions</div>
                                    <div class="feature-subitem">View past training</div>
                                    <div class="feature-subitem">Training details</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-money-bill"></i>
                                <h4>Allowance</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View allowance history</div>
                                    <div class="feature-subitem">Track training-based payments</div>
                                    <div class="feature-subitem">Filter by date range</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-box"></i>
                                <h4>Inventory</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <strong>My Uniform Profile</strong>
                                    <div class="feature-subitem">Add uniform sizes</div>
                                    <div class="feature-subitem">Update sizes</div>
                                    <div class="feature-subitem">Track issue status</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Equipment Loans</strong>
                                    <div class="feature-subitem">Request equipment loan</div>
                                    <div class="feature-subitem">View active loans</div>
                                    <div class="feature-subitem">Return equipment</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-graduation-cap"></i>
                                <h4>Learning Hub</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <strong>Browse Materials</strong>
                                    <div class="feature-subitem">View by category</div>
                                    <div class="feature-subitem">Filter by difficulty</div>
                                    <div class="feature-subitem">Track progress</div>
                                </div>
                                <div class="feature-item">
                                    <strong>Quiz System</strong>
                                    <div class="feature-subitem">Take quizzes</div>
                                    <div class="feature-subitem">View results</div>
                                    <div class="feature-subitem">Track scores</div>
                                    <div class="feature-subitem">View leaderboard</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-trophy"></i>
                                <h4>Performance</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View performance ratings</div>
                                    <div class="feature-subitem">Badge collection</div>
                                    <div class="feature-subitem">Toggle badge display</div>
                                    <div class="feature-subitem">Achievement tracking</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-images"></i>
                                <h4>Gallery</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View photo galleries</div>
                                    <div class="feature-subitem">Browse by category</div>
                                    <div class="feature-subitem">Training photos and events</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-calendar-check"></i>
                                <h4>Attendance</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View attendance records</div>
                                    <div class="feature-subitem">Mark attendance (GPS geofencing)</div>
                                    <div class="feature-subitem">Location-based check-ins</div>
                                    <div class="feature-subitem">Submit absence reasons</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Access -->
            <div class="access-card admin">
                <div class="access-header" onclick="toggleAccess('admin')">
                    <div class="access-title">
                        <div class="access-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h3>Admin Access</h3>
                            <p>System Administration</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon" id="admin-toggle"></i>
                </div>
                <div class="access-content" id="admin-content">
                    <div class="access-body">
                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-tachometer-alt"></i>
                                <h4>Admin Dashboard</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">System overview</div>
                                    <div class="feature-subitem">Administrative controls</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-users-cog"></i>
                                <h4>User Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View all users</div>
                                    <div class="feature-subitem">Search cadets/instructors</div>
                                    <div class="feature-subitem">Update user details</div>
                                    <div class="feature-subitem">Delete users</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-database"></i>
                                <h4>Data Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">View all system data</div>
                                    <div class="feature-subitem">Search data</div>
                                    <div class="feature-subitem">Update data records</div>
                                    <div class="feature-subitem">Delete data records</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-key"></i>
                                <h4>Access Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Transfer admin privileges</div>
                                    <div class="feature-subitem">Manage system access</div>
                                </div>
                            </div>
                        </div>

                        <div class="feature-section">
                            <div class="feature-header">
                                <i class="fas fa-gamepad"></i>
                                <h4>Gamification Management</h4>
                            </div>
                            <div class="feature-items">
                                <div class="feature-item">
                                    <div class="feature-subitem">Create/edit badges</div>
                                    <div class="feature-subitem">Delete badges</div>
                                    <div class="feature-subitem">Configure badge criteria</div>
                                    <div class="feature-subitem">Manage achievements</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Future Plans Section -->
        <div class="features-overview" style="margin-top: 2rem;">
            <h3><i class="fas fa-rocket"></i> Future Plans & Improvements</h3>
            <div class="feature-items">
                <div class="feature-item">
                    <i class="fas fa-chart-pie" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Statistics on the implementation of LT</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-user-check" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Statistics on LT attendance</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-graduation-cap" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Attendance statistics for Phase 3 and Phase 6 compared to current strength</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-running" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Activity statistics compared to overall strength</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-book-reader" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Expand the Learning Hub with interactive and multimedia-based learning content</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt" style="color: var(--primary-blue); margin-right: 0.5rem;"></i>
                    <span style="color: var(--text-primary);">Enhance system security with stronger authentication and refined access control</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} ROTU NAVY UMS - Reserve Officer Training Unit</p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem;">Complete System Navigation & Feature Guide</p>
        </div>
    </div>

    <script>
        function toggleAccess(type) {
            const content = document.getElementById(`${type}-content`);
            const toggle = document.getElementById(`${type}-toggle`);

            // Get all access types
            const allTypes = ['guest', 'instructor', 'cadet', 'admin'];

            // Close all other dropdowns
            allTypes.forEach(t => {
                if (t !== type) {
                    const otherContent = document.getElementById(`${t}-content`);
                    const otherToggle = document.getElementById(`${t}-toggle`);

                    if (otherContent && otherToggle) {
                        otherContent.classList.remove('active');
                        otherToggle.classList.remove('active');
                    }
                }
            });

            // Toggle the clicked dropdown
            content.classList.toggle('active');
            toggle.classList.toggle('active');
        }

        // Video upload functionality
        document.getElementById('videoFile')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Check file size (500MB = 524288000 bytes)
            if (file.size > 524288000) {
                alert('File size exceeds 500MB limit. Please choose a smaller file.');
                return;
            }

            // Check file type
            const allowedTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Please upload MP4, MOV, AVI, or WMV files only.');
                return;
            }

            uploadVideo(file);
        });

        function uploadVideo(file) {
            const formData = new FormData();
            formData.append('video', file);

            const progressBar = document.getElementById('uploadProgress');
            const progressFill = document.getElementById('progressFill');
            const progressText = document.getElementById('progressText');

            progressBar.style.display = 'block';

            const xhr = new XMLHttpRequest();

            // Track upload progress
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressFill.style.width = percentComplete + '%';
                    progressText.textContent = `Uploading... ${percentComplete}%`;
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    progressText.textContent = 'Upload complete! Refreshing page...';
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    const error = JSON.parse(xhr.responseText);
                    alert('Upload failed: ' + (error.error || 'Unknown error'));
                    progressBar.style.display = 'none';
                }
            });

            xhr.addEventListener('error', function() {
                alert('Upload failed. Please try again.');
                progressBar.style.display = 'none';
            });

            xhr.open('POST', '{{ route('demo.upload.video') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.send(formData);
        }

        function deleteVideo() {
            if (!confirm('Are you sure you want to delete the demo video?')) {
                return;
            }

            fetch('{{ route('demo.delete.video') }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Video deleted successfully!');
                    location.reload();
                } else {
                    alert('Failed to delete video: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error deleting video. Please try again.');
                console.error('Error:', error);
            });
        }

        // Optional: Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
