<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Sitemap - ROTU NAVY UMS</title>
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
            line-height: 1.6;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .home-button {
            position: absolute;
            left: 0;
            top: 0;
            background: var(--gradient-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
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
            font-size: 3rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* System Highlights Section */
        .highlights-section {
            margin-bottom: 3rem;
        }

        .highlights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .highlight-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
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
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .highlight-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .highlight-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .highlight-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .features-overview {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
        }

        .features-overview h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--primary-blue);
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .feature-badge {
            background: rgba(60, 146, 217, 0.1);
            border: 1px solid rgba(60, 146, 217, 0.3);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .feature-badge:hover {
            background: rgba(60, 146, 217, 0.2);
            border-color: var(--primary-blue);
            transform: translateX(5px);
        }

        .feature-badge i {
            color: var(--primary-blue);
            font-size: 1.2rem;
        }

        .feature-badge span {
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        /* Video Section */
        .video-section {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            backdrop-filter: blur(10px);
        }

        .video-section h2 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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
            margin-bottom: 2rem;
        }

        .sitemap-intro h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sitemap-intro p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        /* Landing Page Box */
        .landing-box {
            background: var(--gradient-primary);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-primary);
        }

        .landing-box h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .landing-box p {
            opacity: 0.9;
        }

        /* Branch Container */
        .branches-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Access Card */
        .access-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .access-card:hover {
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-primary);
            transform: translateY(-5px);
        }

        .access-card.guest { border-top: 4px solid #10b981; }
        .access-card.instructor { border-top: 4px solid var(--primary-blue); }
        .access-card.cadet { border-top: 4px solid var(--accent-pink); }
        .access-card.admin { border-top: 4px solid #f59e0b; }

        .access-header {
            padding: 1.5rem;
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
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .guest .access-icon { background: linear-gradient(135deg, #10b981, #059669); }
        .instructor .access-icon { background: var(--gradient-primary); }
        .cadet .access-icon { background: linear-gradient(135deg, #ec6c6c, #e74c3c); }
        .admin .access-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .access-title h3 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .access-title p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .toggle-icon {
            font-size: 1.2rem;
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
            padding: 1.5rem;
        }

        /* Feature Section */
        .feature-section {
            margin-bottom: 1.5rem;
        }

        .feature-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(60, 146, 217, 0.1);
            border-left: 4px solid var(--primary-blue);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .feature-header:hover {
            background: rgba(60, 146, 217, 0.15);
        }

        .feature-header i {
            color: var(--primary-blue);
            font-size: 1.2rem;
        }

        .feature-header h4 {
            font-size: 1.1rem;
            font-weight: 600;
            flex: 1;
        }

        .feature-items {
            padding-left: 2.5rem;
            margin-top: 0.5rem;
        }

        .feature-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border-left: 3px solid rgba(60, 146, 217, 0.3);
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
            margin-bottom: 0.25rem;
        }

        .feature-subitem {
            padding-left: 1rem;
            margin: 0.25rem 0;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .feature-subitem::before {
            content: "→";
            color: var(--primary-blue);
            margin-right: 0.5rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
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
            <h1>System Sitemap</h1>
            <p>Complete navigation guide for ROTU NAVY UMS</p>
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
                        <i class="fas fa-calendar-alt"></i>
                        <span>Attendance Tracking</span>
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
                        <i class="fas fa-book-open"></i>
                        <span>Learning Hub</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-brain"></i>
                        <span>Quiz System</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-chart-line"></i>
                        <span>Performance Analytics</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Allowance Tracking</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-medal"></i>
                        <span>Badge Awards</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-file-export"></i>
                        <span>Report Generation</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-images"></i>
                        <span>Gallery System</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Role-Based Access</span>
                    </div>
                    <div class="feature-badge">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Responsive Design</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-section">
            <h2>
                <i class="fas fa-video"></i>
                System Demo Video (15 minutes)
            </h2>
            <div class="video-container">
                <div class="video-placeholder">
                    <i class="fas fa-film"></i>
                    <p>Video demo will be displayed here</p>
                    <p style="font-size: 0.9rem; opacity: 0.7;">Upload your 15-minute demo video to showcase the system</p>
                </div>
                <!-- To add video, replace the placeholder with: -->
                <!-- <video controls>
                    <source src="/path/to/your/video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video> -->
            </div>
        </div>

        <!-- Sitemap Introduction -->
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

            content.classList.toggle('active');
            toggle.classList.toggle('active');
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
