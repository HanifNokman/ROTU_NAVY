<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROTU NAVY UMS - Reserve Officer Training Unit</title>
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
            overflow-x: hidden;
            background-color: var(--dark-navy);
            color: var(--text-primary);
            line-height: 1.7;
            scroll-behavior: smooth;
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

        .nav-links .btn-primary {
            padding: 12px 24px !important;
            margin: 0 1rem;
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

        .btn-primary::after {
            display: none !important;
        }

        .btn-instructor {
            background: linear-gradient(135deg, #ec6c6c, #d64545);
            margin-left: 0.5rem;
        }

        .btn-instructor:hover {
            background: linear-gradient(135deg, #d64545, #b83838);
            box-shadow: 0 8px 25px rgba(236, 108, 108, 0.5);
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

        /* Notification Banner */
.notification-banner {
    background: var(--gradient-primary);
    padding: 2rem 2rem 1rem 2rem;
    text-align: center;
    margin-top: 81px;
    border-bottom: 2px solid rgba(60, 146, 217, 0.3);
    transition: all 0.3s ease;
}

.notification-banner.hidden {
    display: none;
}

.notification-banner h3 {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.notification-banner p {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
}

.notification-close {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.notification-close:hover {
    opacity: 1;
}

/* Hero Section with Image Carousel */
.hero-section {
    position: relative;
    height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-carousel {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-slide.active {
    opacity: 1;
}

.hero-slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(rgba(46, 49, 60, 0.7), rgba(60, 146, 217, 0.5));
    z-index: 2;
}

.hero-carousel-indicators {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 15;
}

.hero-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.hero-indicator.active {
    background: var(--primary-blue);
    transform: scale(1.2);
    border-color: rgba(255, 255, 255, 0.3);
}

.hero-carousel-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(60, 146, 217, 0.8);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 15;
    font-size: 1.2rem;
}

.hero-carousel-nav:hover {
    background: var(--primary-blue);
    transform: translateY(-50%) scale(1.1);
}

.hero-carousel-nav.prev {
    left: 30px;
}

.hero-carousel-nav.next {
    right: 30px;
}

.hero-content {
    text-align: center;
    z-index: 10;
    max-width: 1000px;
    padding: 0 2rem;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(3rem, 6vw, 5.5rem);
    font-weight: 700;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--text-primary), var(--primary-blue));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: fadeInUp 1s ease 0.4s both;
    line-height: 1.1;
}

.hero-subtitle {
    font-size: clamp(1.25rem, 2.5vw, 1.75rem);
    color: var(--text-secondary);
    margin-bottom: 3rem;
    animation: fadeInUp 1s ease 0.6s both;
    font-weight: 400;
}

.hero-cta {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
    animation: fadeInUp 1s ease 0.8s both;
}

.btn-secondary {
    background: transparent;
    border: 2px solid var(--primary-blue);
    color: var(--primary-blue);
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-secondary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-blue);
    transition: left 0.3s ease;
    z-index: -1;
}

.btn-secondary:hover::before {
    left: 0;
}

.btn-secondary:hover {
    color: white;
    transform: translateY(-2px);
}

/* Floating Elements */
.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.floating-icon {
    position: absolute;
    font-size: 2rem;
    color: rgba(60, 146, 217, 0.1);
    animation: float 6s ease-in-out infinite;
}

.floating-icon:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
.floating-icon:nth-child(2) { top: 30%; right: 15%; animation-delay: 2s; }
.floating-icon:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 4s; }
.floating-icon:nth-child(4) { bottom: 20%; right: 10%; animation-delay: 1s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Statistics Section */
.stats-section {
    background: rgba(16, 20, 28, 0.95);
    padding: 4rem 2rem;
    margin-top: -1px;
}

.stats-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 3rem;
}

.stat-item {
    text-align: center;
    padding: 2rem;
    border-radius: 12px;
    background: rgba(60, 146, 217, 0.1);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(60, 146, 217, 0.1), transparent);
    transition: left 0.8s;
}

.stat-item:hover::before {
    left: 100%;
}

.stat-item:hover {
    transform: translateY(-5px);
    border-color: var(--primary-blue);
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    color: var(--primary-blue);
    margin-bottom: 0.5rem;
    display: block;
}

.stat-label {
    font-size: 1rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* Enhanced Sections */
.section {
    padding: 6rem 2rem;
    position: relative;
}

.section-container {
    max-width: 1400px;
    margin: 0 auto;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-badge {
    display: inline-block;
    background: rgba(60, 146, 217, 0.1);
    border: 1px solid var(--primary-blue);
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.875rem;
    color: var(--primary-blue);
    margin-bottom: 1rem;
    font-weight: 500;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
}

.section-description {
    font-size: 1.125rem;
    color: var(--text-secondary);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

/* Enhanced Cards */
.enhanced-card {
    background: rgba(60, 146, 217, 0.05);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 3rem;
    border: 1px solid var(--border-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.enhanced-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gradient-accent);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.enhanced-card:hover::before {
    transform: scaleX(1);
}

.enhanced-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
    border-color: rgba(60, 146, 217, 0.3);
}

/* Interactive Timeline */
.timeline {
    position: relative;
    margin: 4rem 0;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

/* Force timeline visibility for debugging */
.timeline-item {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: var(--gradient-primary);
    transform: translateX(-50%);
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    margin: 6rem 0;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-item.visible {
    opacity: 1;
    transform: translateY(0);
}

.timeline-content {
    background: rgba(60, 146, 217, 0.1);
    border-radius: 16px;
    padding: 2.5rem;
    width: 45%;
    max-width: 500px;
    position: relative;
    border: 2px solid var(--border-color);
    overflow: hidden;
    min-height: 350px;
    cursor: pointer;
    transition: all 0.4s ease;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}

.timeline-content:hover {
    transform: translateY(-8px);
    border-color: var(--primary-blue);
    box-shadow: 0 20px 50px rgba(60, 146, 217, 0.3);
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-right: auto;
    margin-left: 0;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: auto;
    margin-right: 0;
}

.timeline-content-inner {
    width: 100%;
    text-align: center;
    z-index: 2;
    position: relative;
}

.timeline-icon {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 70px;
    height: 70px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    border: 6px solid var(--dark-navy);
    z-index: 10;
    box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
    transition: all 0.3s ease;
}

.timeline-item:hover .timeline-icon {
    transform: translate(-50%, -50%) scale(1.1);
    box-shadow: 0 12px 35px rgba(60, 146, 217, 0.6);
}

/* Interactive Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 4rem;
}

.feature-card {
    background: rgba(60, 146, 217, 0.05);
    border-radius: 16px;
    padding: 3.5rem;
    border: 1px solid var(--border-color);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(60, 146, 217, 0.05) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary-blue);
    box-shadow: 0 20px 40px rgba(60, 146, 217, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.feature-card:hover .feature-icon {
    transform: scale(1.1) rotate(5deg);
    background: var(--gradient-accent);
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.feature-description {
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Requirements Section */
.requirements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 4rem;
}

.requirement-card {
    background: rgba(60, 146, 217, 0.05);
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.requirement-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary-blue);
    box-shadow: 0 20px 40px rgba(60, 146, 217, 0.15);
}

.requirement-card h3 {
    color: var(--primary-blue);
    font-size: 1.3rem;
    margin-bottom: 1rem;
    text-align: center;
    border-bottom: 2px solid var(--primary-blue);
    padding-bottom: 0.5rem;
}

.requirement-card ul {
    list-style: none;
    padding: 0;
}

.requirement-card li {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    padding-left: 1.5rem;
}

.requirement-card li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--primary-blue);
    font-weight: bold;
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
    background-color: rgba(0,0,0,0.8);
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: var(--dark-navy);
    margin: 2% auto;
    padding: 2rem;
    border-radius: 16px;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    border: 2px solid rgba(60, 146, 217, 0.3);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid rgba(60, 146, 217, 0.3);
    padding-bottom: 1rem;
}

.modal-header h2 {
    color: var(--primary-blue);
    margin-bottom: 0;
}

.close-btn {
    background: none;
    border: none;
    color: var(--accent-pink);
    font-size: 2rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-btn:hover {
    color: #ff4444;
    transform: scale(1.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--primary-blue);
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 2px solid rgba(60, 146, 217, 0.3);
    background: rgba(60, 146, 217, 0.1);
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 10px rgba(60, 146, 217, 0.3);
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.modal-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-secondary-modal {
    background: rgba(108, 117, 125, 0.8);
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-secondary-modal:hover {
    background: rgba(108, 117, 125, 1);
    transform: translateY(-2px);
}

/* Enhanced Footer */
.footer {
    background: rgba(16, 20, 28, 0.98);
    padding: 4rem 2rem 2rem;
    border-top: 1px solid var(--border-color);
    position: relative;
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

.footer-content {
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.footer-section h3 {
    color: var(--primary-blue);
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
    font-weight: 600;
}

.footer-section p, .footer-section li {
    color: var(--text-secondary);
    margin-bottom: 0.75rem;
    transition: color 0.3s ease;
}

.footer-section a {
    color: var(--text-secondary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: var(--primary-blue);
}

.social-icons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-icon {
    width: 50px;
    height: 50px;
    background: rgba(60, 146, 217, 0.1);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 1.25rem;
    color: var(--text-secondary);
}

.social-icon:hover {
    background: var(--gradient-primary);
    color: white;
    transform: translateY(-3px);
    border-color: var(--primary-blue);
}

.footer-bottom {
    text-align: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
    color: var(--text-secondary);
}

/* Animations */
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

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-on-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.animate-on-scroll.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Page Loader */
.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--dark-navy);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.page-loader.loaded {
    opacity: 0;
    visibility: hidden;
}

.loader {
    width: 60px;
    height: 60px;
    border: 3px solid rgba(60, 146, 217, 0.1);
    border-top: 3px solid var(--primary-blue);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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

    .hero-cta {
        flex-direction: column;
        align-items: center;
    }

    .stats-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .timeline::before {
        left: 30px;
    }

    .timeline-content {
        width: calc(100% - 80px);
        margin-left: 80px !important;
        min-height: 250px;
    }

    .timeline-icon {
        left: 30px;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .requirements-grid {
        grid-template-columns: 1fr;
    }

    .section {
        padding: 4rem 1rem;
    }

    .enhanced-card {
        padding: 2rem;
    }
}

@media (max-width: 480px) {
    .stats-container {
        grid-template-columns: 1fr;
    }

    .stat-number {
        font-size: 2.5rem;
    }

    .feature-card {
        padding: 2rem;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .footer-section {
        padding: 0;
        margin-bottom: 1rem;
    }

    .footer-section h3 {
        text-align: center;
    }
}


    </style>
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>
    
    <!-- Navigation -->
<nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#home" class="nav-logo" id="logoLink">
                <img src="storage/landing/PSS-LOGO.png" alt="ROTU Logo">
                <div class="nav-logo-text">
                    <span class="main-title">PALAPES</span>
                    <span class="sub-title">LAUT UMS</span>
                </div>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#introduction">Introduction</a></li>
                <li><a href="#timeline">Journey</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#benefits">Benefits</a></li>
                <li><a href="#requirements">Requirements</a></li>
                <li><a href="#selection">Selection</a></li>
                <li><a href="#application">Apply</a></li>
                
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
            
            <!-- Instructor Edit Button (moved outside nav-links for separation) -->
            <!-- @auth -->
                <!-- @if(auth()->user()->role === 'instructor') -->
                    <button class="btn-primary btn-instructor" id="editBtn">
                        <i class="fas fa-edit"></i> Edit Page
                    </button>
                <!-- @endif -->
            <!-- @endauth -->
            
            <div class="mobile-menu-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

<!-- Notification Banner -->
<section class="notification-banner" id="notificationBanner" style="position: relative;">
    <h3 id="notificationTitle">
        <i class="fas fa-bullhorn"></i>
        Next Intake Application Open!
    </h3>
    <p id="notificationText">Applications for the upcoming semester are now open. Deadline: March 31, 2025</p>
    <button class="notification-close" id="closeNotification" onclick="hideNotification()">
        <i class="fas fa-times"></i>
    </button>
</section>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="hero-carousel" id="heroCarousel">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1920&h=1080&fit=crop')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920&h=1080&fit=crop')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1920&h=1080&fit=crop')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1562408590-e32931084e23?w=1920&h=1080&fit=crop')"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=1920&h=1080&fit=crop')"></div>
    </div>
    
    <button class="hero-carousel-nav prev" id="prevSlide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-carousel-nav next" id="nextSlide">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <div class="hero-carousel-indicators" id="heroIndicators">
        <div class="hero-indicator active" data-slide="0"></div>
        <div class="hero-indicator" data-slide="1"></div>
        <div class="hero-indicator" data-slide="2"></div>
        <div class="hero-indicator" data-slide="3"></div>
        <div class="hero-indicator" data-slide="4"></div>
    </div>
    
    <div class="floating-elements">
        <i class="fas fa-anchor floating-icon"></i>
        <i class="fas fa-shield-alt floating-icon"></i>
        <i class="fas fa-medal floating-icon"></i>
        <i class="fas fa-graduation-cap floating-icon"></i>
    </div>
    <div class="hero-content">
        <h1 class="hero-title" id="heroTitle">Excellence in Maritime Leadership</h1>
        <p class="hero-subtitle" id="heroSubtitle">Forge your path as a naval officer through comprehensive training, leadership development, and academic excellence at Universiti Malaysia Sabah</p>
        <div class="hero-cta">
            <a href="#application" class="btn-primary">
                <i class="fas fa-user-plus"></i> Apply Now
            </a>
            <a href="#introduction" class="btn-secondary">
                <i class="fas fa-info-circle"></i> Learn More
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="stats-container">
        <div class="stat-item animate-on-scroll">
            <span class="stat-number" data-count="500">0</span>
            <span class="stat-label">Graduates</span>
        </div>
        <div class="stat-item animate-on-scroll">
            <span class="stat-number" data-count="11">0</span>
            <span class="stat-label">Intakes Commissioned</span>
        </div>
        <div class="stat-item animate-on-scroll">
            <span class="stat-number" data-count="95">0</span>
            <span class="stat-label">% Success Rate</span>
        </div>
        <div class="stat-item animate-on-scroll">
            <span class="stat-number" data-count="120">0</span>
            <span class="stat-label">Active Cadets</span>
        </div>
    </div>
</section>

<!-- Introduction Section -->
<section id="introduction" class="section">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Program Overview</div>
            <h2 class="section-title">About PALAPES Laut UMS</h2>
            <p class="section-description" id="introDescription">
                The Reserve Officer Training Unit (PALAPES) represents Malaysia's premier naval leadership development program, combining rigorous academic excellence with comprehensive military training to forge the next generation of maritime leaders.
            </p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 4rem;">
            <div class="enhanced-card animate-on-scroll">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=300&fit=crop" alt="PALAPES Training" style="width: 100%; height: 300px; object-fit: cover; border-radius: 12px; margin-bottom: 2rem;">
                <h3 style="color: var(--primary-blue); margin-bottom: 1rem; font-size: 1.5rem;">Our Mission</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    To develop exceptional maritime leaders through comprehensive training that combines academic excellence, military discipline, and character development, preparing graduates to serve with honor in Malaysia's naval forces and civilian sectors.
                </p>
            </div>

            <div class="enhanced-card animate-on-scroll">
                <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.5rem;">Program Highlights</h3>
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-graduation-cap" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Academic Integration</h4>
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">Seamless blend of military training with university education</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Leadership Development</h4>
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">Comprehensive leadership training and practical experience</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-anchor" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Naval Excellence</h4>
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">Advanced maritime skills and naval operations training</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

<!-- Cadet Timeline Section -->
<section id="timeline" class="section">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Training Excellence</div>
            <h2 class="section-title">Cadet Journey Timeline</h2>
            <p class="section-description">
                Follow the comprehensive path from application to commission, designed to transform dedicated students into exceptional naval officers through structured training phases.
            </p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=500&h=300&fit=crop'); background-size: cover; background-position: center;">
                    <div class="timeline-content-inner">
                        <h3 style="color: var(--primary-blue); font-size: 1.6rem; margin-bottom: 1rem; text-align: center; font-weight: 700;">Foundation Training</h3>
                        <p style="color: var(--text-secondary); line-height: 1.7; text-align: center; font-size: 1rem;">Comprehensive introduction to naval traditions, basic seamanship, military fundamentals, discipline, and core competencies in leadership and maritime knowledge. Duration: 6 months intensive training.</p>
                    </div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-anchor"></i>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=500&h=300&fit=crop'); background-size: cover; background-position: center;">
                    <div class="timeline-content-inner">
                        <h3 style="color: var(--primary-blue); font-size: 1.6rem; margin-bottom: 1rem; text-align: center; font-weight: 700;">Advanced Maritime Skills</h3>
                        <p style="color: var(--text-secondary); line-height: 1.7; text-align: center; font-size: 1rem;">Specialized training in navigation systems, vessel operations, maritime law, advanced seamanship, and practical experience through simulations and real-world exercises. Duration: 12 months advanced training.</p>
                    </div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-compass"></i>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop'); background-size: cover; background-position: center;">
                    <div class="timeline-content-inner">
                        <h3 style="color: var(--primary-blue); font-size: 1.6rem; margin-bottom: 1rem; text-align: center; font-weight: 700;">Leadership Development</h3>
                        <p style="color: var(--text-secondary); line-height: 1.7; text-align: center; font-size: 1rem;">Intensive leadership training, command responsibilities, strategic thinking, team management, and preparation for officer-level decision making and personnel management. Take on leadership roles and mentor junior cadets.</p>
                    </div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('https://images.unsplash.com/photo-1562408590-e32931084e23?w=500&h=300&fit=crop'); background-size: cover; background-position: center;">
                    <div class="timeline-content-inner">
                        <h3 style="color: var(--primary-blue); font-size: 1.6rem; margin-bottom: 1rem; text-align: center; font-weight: 700;">Commission Readiness</h3>
                        <p style="color: var(--text-secondary); line-height: 1.7; text-align: center; font-size: 1rem;">Final preparation for commissioning as Second Lieutenant Officers Naval Volunteer Reserve (NVR), comprehensive evaluation, and graduation ceremony. Ready to serve Malaysia's naval defense with distinction.</p>
                    </div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section" style="background: linear-gradient(135deg, rgba(16, 20, 28, 0.95), rgba(60, 146, 217, 0.1));">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Our Legacy</div>
            <h2 class="section-title">Excellence Through Tradition</h2>
            <p class="section-description" id="aboutDescription">
                With decades of proven success, PALAPES has established itself as the premier institution for developing maritime leaders who serve with distinction in both military and civilian capacities, upholding the highest standards of honor, courage, and commitment.
            </p>
        </div>

        <div class="enhanced-card animate-on-scroll" style="text-align: center; margin-top: 4rem;">
            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=500&fit=crop" alt="PALAPES Cadets Formation" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);">
            <h3 style="color: var(--primary-blue); font-size: 2rem; margin-bottom: 1.5rem;">Building Tomorrow's Leaders</h3>
            <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.8; max-width: 800px; margin: 0 auto;">
                Our comprehensive program goes beyond traditional military training, fostering critical thinking, ethical leadership, and the adaptability required to excel in an ever-changing global environment. Graduates emerge as confident, capable leaders ready to make meaningful contributions to society.
            </p>
        </div>
    </div>
</section>

<div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

<!-- Benefits Section -->
<section id="benefits" class="section">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Program Benefits</div>
            <h2 class="section-title">Comprehensive Support System</h2>
            <p class="section-description">
                PALAPES provides extensive support to ensure cadet success through financial assistance, accommodation, equipment provision, and unparalleled career development opportunities.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="feature-title">Monthly Allowance</h3>
                <p class="feature-description">Competitive monthly stipend throughout the training period to support living expenses and reduce financial burden, allowing you to focus entirely on your development.</p>
            </div>

            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <h3 class="feature-title">Complete Uniform & Equipment</h3>
                <p class="feature-description">Full provision of military uniforms, ceremonial dress, training gear, and specialized equipment required for all program activities and formal occasions.</p>
            </div>

            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3 class="feature-title">Guaranteed Campus Housing</h3>
                <p class="feature-description">Priority accommodation in university residential facilities with specialized cadet quarters designed to foster camaraderie and academic success.</p>
            </div>

            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-crosshairs"></i>
                </div>
                <h3 class="feature-title">Professional Military Training</h3>
                <p class="feature-description">Comprehensive firearms training, advanced naval operations, tactical planning, and specialized maritime skills under expert military instruction.</p>
            </div>

            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <h3 class="feature-title">Leadership Excellence</h3>
                <p class="feature-description">Develop essential leadership capabilities, strategic thinking, decision-making skills, and command presence that will distinguish you throughout your career.</p>
            </div>

            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h3 class="feature-title">Elite Professional Network</h3>
                <p class="feature-description">Access to exclusive alumni networks, military associations, and leadership communities across Malaysia and internationally for lifelong career benefits.</p>
            </div>
        </div>
    </div>
</section>

<!-- Requirements Section -->
<section id="requirements" class="section" style="background: linear-gradient(135deg, rgba(16, 20, 28, 0.95), rgba(60, 146, 217, 0.1));">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Eligibility Criteria</div>
            <h2 class="section-title">Application Requirements</h2>
            <p class="section-description">
                We seek exceptional individuals who demonstrate academic excellence, physical fitness, moral character, and the potential for outstanding military leadership development.
            </p>
        </div>

        <div class="requirements-grid">
            <div class="requirement-card animate-on-scroll">
                <h3>General Requirements</h3>
                <ul>
                    <li>Malaysian citizen by birth</li>
                    <li>Full-time university student at UMS</li>
                    <li>Age 18-25 years</li>
                    <li>Clean criminal record</li>
                    <li>CGPA ≥ 2.5 minimum</li>
                    <li>Demonstrated leadership potential</li>
                </ul>
            </div>
            
            <div class="requirement-card animate-on-scroll">
                <h3>Physical Requirements</h3>
                <ul>
                    <li>Excellent physical fitness level</li>
                    <li>Swimming proficiency (200m)</li>
                    <li>Pass standardized fitness test</li>
                    <li>Height: Min 160cm (M), 155cm (F)</li>
                    <li>BMI within military standards</li>
                    <li>No chronic physical disabilities</li>
                </ul>
            </div>
            
            <div class="requirement-card animate-on-scroll">
                <h3>Medical Requirements</h3>
                <ul>
                    <li>Complete medical clearance</li>
                    <li>Normal vision (correctable to 6/6)</li>
                    <li>Normal hearing capacity</li>
                    <li>No serious mental health history</li>
                    <li>Drug-free medical screening</li>
                    <li>Current vaccination records</li>
                </ul>
            </div>
            
            <div class="requirement-card animate-on-scroll">
                <h3>Required Documents</h3>
                <ul>
                    <li>Completed application form</li>
                    <li>Academic transcripts</li>
                    <li>Identity card copy</li>
                    <li>Birth certificate copy</li>
                    <li>Medical examination report</li>
                    <li>Character reference letters (2)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Selection Process Section -->
<section id="selection" class="section">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Selection Process</div>
            <h2 class="section-title">Path to Acceptance</h2>
            <p class="section-description">
                Our comprehensive selection process ensures we identify candidates with the highest potential for success in military leadership and academic excellence.
            </p>
        </div>

        <div class="features-grid">
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">1</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Document Review</h3>
                <p style="color: var(--text-secondary);">Initial screening of application documents, academic records, and eligibility verification by our expert selection committee.</p>
            </div>
            
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">2</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Written Examination</h3>
                <p style="color: var(--text-secondary);">Comprehensive written test covering general knowledge, current affairs, mathematics, logical reasoning, and maritime awareness.</p>
            </div>
            
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">3</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Physical Assessment</h3>
                <p style="color: var(--text-secondary);">Rigorous physical fitness evaluation including endurance tests, strength assessments, swimming proficiency, and obstacle courses.</p>
            </div>
            
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">4</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Medical Examination</h3>
                <p style="color: var(--text-secondary);">Comprehensive medical screening conducted by certified military medical officers to ensure complete fitness for naval service.</p>
            </div>
            
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">5</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Panel Interview</h3>
                <p style="color: var(--text-secondary);">In-depth interview with senior officers and instructors to assess leadership potential, motivation, character, and commitment to service.</p>
            </div>
            
            <div class="enhanced-card animate-on-scroll" style="position: relative;">
                <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">6</div>
                <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Final Selection</h3>
                <p style="color: var(--text-secondary);">Successful candidates receive formal offer letters and begin their transformative journey as PALAPES cadets.</p>
            </div>
        </div>
    </div>
</section>

<!-- Application Section -->
<section id="application" class="section">
    <div class="section-container">
        <div class="section-header animate-on-scroll">
            <div class="section-badge">Join PALAPES</div>
            <h2 class="section-title">Begin Your Leadership Journey</h2>
            <p class="section-description">
                Take the first decisive step toward becoming a commissioned naval officer. Our comprehensive application process ensures we select the most qualified and dedicated candidates for this prestigious program.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 4rem;">
            <div class="enhanced-card animate-on-scroll">
                <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.75rem;">Application Process</h3>
                
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: var(--text-primary); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-file-alt" style="color: var(--primary-blue);"></i>
                        Required Steps
                    </h4>
                    <ol style="color: var(--text-secondary); font-size: 1rem; line-height: 1.8; padding-left: 1.5rem;">
                        <li style="margin-bottom: 0.75rem;">Verify you meet all program requirements</li>
                        <li style="margin-bottom: 0.75rem;">Complete online application form</li>
                        <li style="margin-bottom: 0.75rem;">Submit all required documents</li>
                        <li style="margin-bottom: 0.75rem;">Attend selection assessments</li>
                        <li style="margin-bottom: 0.75rem;">Begin your PALAPES journey!</li>
                    </ol>
                </div>

                <div style="margin-bottom: 2rem;">
                    <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.5rem;">Ready to serve Malaysia?</p>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">Apply today to join PALAPES Laut UMS and develop the leadership skills, discipline, and character that will distinguish you for life.</p>
                </div>

                <div style="text-align: center;">
                    <a href="#" id="applicationPortalLink" class="btn-primary" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; font-size: 1.1rem;">
                        <i class="fas fa-external-link-alt"></i>
                        Access Application Portal
                    </a>
                </div>
            </div>

            <div class="enhanced-card animate-on-scroll" style="text-align: center;">
                <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.75rem;">Quick Access QR Code</h3>
                
                <div style="width: 280px; height: 280px; background: white; margin: 0 auto 2rem; border-radius: 16px; display: flex; align-items: center; justify-content: center; position: relative; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                    <img id="qrCodeImage" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQwIiBoZWlnaHQ9IjI0MCIgdmlld0JveD0iMCAwIDI0MCAyNDAiIHN0eWxlPSJib3JkZXItcmFkaXVzOiA4cHg7Ij4KPHJlY3Qgd2lkdGg9IjI0MCIgaGVpZ2h0PSIyNDAiIGZpbGw9IndoaXRlIi8+CjxyZWN0IHg9IjIwIiB5PSIyMCIgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSJibGFjayIvPgo8cmVjdCB4PSIzMCIgeT0iMzAiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgZmlsbD0id2hpdGUiLz4KPHJlY3QgeD0iNDAiIHk9IjQwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE2MCIgeT0iMjAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTcwIiB5PSIzMCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB4PSIxODAiIHk9IjQwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjIwIiB5PSIxNjAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMzAiIHk9IjE3MCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB4PSI0MCIgeT0iMTgwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjkwIiB5PSIyMCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTA2IiB5PSIyMCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTIyIiB5PSIyMCIgd2lkdGg9IjgiIGhlaWdodD0iOCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTAwIiB5PSIxMDAiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTEwIiB5PSIxMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0id2hpdGUiLz4KPHJlY3QgeD0iMTE1IiB5PSIxMTUiIHdpZHRoPSIxMCIgaGVpZ2h0PSIxMCIgZmlsbD0iYmxhY2siLz4KPC9zdmc+" alt="QR Code" style="width: 240px; height: 240px; border-radius: 8px;">
                </div>
                
                <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.5rem; font-size: 1.1rem;">Scan for Instant Access</p>
                <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 2rem;">Use your mobile device to scan this QR code and access the PALAPES application portal directly</p>
                
                <div style="background: rgba(60, 146, 217, 0.1); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(60, 146, 217, 0.2);">
                    <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem;">Need Assistance?</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Contact our admissions team for application support and program inquiries</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>PALAPES Laut UMS</h3>
            <p>The Reserve Officer Training Unit at Universiti Malaysia Sabah is committed to developing exceptional maritime leaders through comprehensive training, academic excellence, and character development.</p>
            <div class="social-icons">
                <a href="#" class="social-icon" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="#" class="social-icon" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-icon" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Contact Information</h3>
            <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem;">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-blue); margin-top: 0.25rem;"></i>
                <div>
                    <p>PALAPES Office, Block B</p>
                    <p>Universiti Malaysia Sabah</p>
                    <p>Jalan UMS, 88400 Kota Kinabalu</p>
                    <p>Sabah, Malaysia</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <i class="fas fa-phone" style="color: var(--primary-blue);"></i>
                <p>+60 88-320-000 ext. 5001</p>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-envelope" style="color: var(--primary-blue);"></i>
                <p>palapeslautums@ums.edu.my</p>
            </div>
        </div>

        <div class="footer-section">
            <h3>Find Us Here</h3>
            <div style="width: 100%; height: 200px; background: rgba(60, 146, 217, 0.1); border-radius: 8px; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; overflow: hidden;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d991.9088727330876!2d116.1296105786893!3d6.044647273346967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smy!4v1758376029404!5m2!1sen!2smy" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-blue); margin-top: 0.25rem;"></i>
                <div>
                    <p style="margin-bottom: 0.25rem; font-weight: 600; color: var(--text-primary);">Visit Our Campus</p>
                    <p style="margin: 0; font-size: 0.9rem;">Block B, Universiti Malaysia Sabah<br>Jalan UMS, 88400 Kota Kinabalu<br>Sabah, Malaysia</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2024 PALAPES Laut UMS - Reserve Officer Training Unit, Universiti Malaysia Sabah. All rights reserved.</p>
        <p style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--text-secondary);">
            Developing Maritime Leaders | Building Character | Serving Malaysia
        </p>
    </div>
</footer>

<!-- Instructor Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Landing Page Content</h2>
            <button class="close-btn" id="closeModal">&times;</button>
        </div>
        <form id="editForm">
            <div class="form-group">
                <label for="heroTitle">Hero Section Title:</label>
                <input type="text" id="heroTitle" name="heroTitle" value="Excellence in Maritime Leadership">
            </div>
            
            <div class="form-group">
                <label for="heroSubtitle">Hero Section Subtitle:</label>
                <textarea id="heroSubtitle" name="heroSubtitle" rows="2">Forge your path as a naval officer through comprehensive training, leadership development, and academic excellence at Universiti Malaysia Sabah</textarea>
            </div>
            
            <div class="form-group">
                <label for="introDescription">Introduction Description:</label>
                <textarea id="introDescription" name="introDescription" rows="3">The Reserve Officer Training Unit (PALAPES) represents Malaysia's premier naval leadership development program, combining rigorous academic excellence with comprehensive military training to forge the next generation of maritime leaders.</textarea>
            </div>
            
            <div class="form-group">
                <label for="aboutDescription">About Section Description:</label>
                <textarea id="aboutDescription" name="aboutDescription" rows="3">With decades of proven success, PALAPES has established itself as the premier institution for developing maritime leaders who serve with distinction in both military and civilian capacities, upholding the highest standards of honor, courage, and commitment.</textarea>
            </div>
            
            <div class="form-group">
                <label for="applicationDeadline">Application Deadline Date:</label>
                <input type="date" id="applicationDeadline" name="applicationDeadline" min="2024-01-01">
                <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                    <i class="fas fa-info-circle"></i> 
                    Banner will show 1 month before deadline and disappear the day after
                </small>
            </div>
            
            <div class="form-group">
                <label for="applicationPortalUrl">Application Portal URL:</label>
                <input type="url" id="applicationPortalUrl" name="applicationPortalUrl" placeholder="https://example.com/application">
                <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                    <i class="fas fa-link"></i> 
                    URL that the "Access Application Portal" button will redirect to
                </small>
            </div>

            <div class="form-group">
                <label for="qrCodeImage">QR Code / Quick Access Image:</label>
                <input type="file" id="qrCodeImageUpload" name="qrCodeImage" accept="image/*">
                <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                    <i class="fas fa-qrcode"></i> 
                    Upload a custom QR code or any image to replace the default QR code
                </small>
            </div>

            <div class="form-group">
                <label for="heroImage1">Hero Carousel Image 1:</label>
                <input type="file" id="heroImage1" name="heroImage1" accept="image/*">
            </div>

            <div class="form-group">
                <label for="heroImage2">Hero Carousel Image 2:</label>
                <input type="file" id="heroImage2" name="heroImage2" accept="image/*">
            </div>

            <div class="form-group">
                <label for="heroImage3">Hero Carousel Image 3:</label>
                <input type="file" id="heroImage3" name="heroImage3" accept="image/*">
            </div>

            <div class="form-group">
                <label for="heroImage4">Hero Carousel Image 4:</label>
                <input type="file" id="heroImage4" name="heroImage4" accept="image/*">
            </div>

            <div class="form-group">
                <label for="heroImage5">Hero Carousel Image 5:</label>
                <input type="file" id="heroImage5" name="heroImage5" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="introImage">Introduction Section Image:</label>
                <input type="file" id="introImage" name="introImage" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="aboutImage">About Section Image:</label>
                <input type="file" id="aboutImage" name="aboutImage" accept="image/*">
            </div>
            
            <div class="modal-buttons">
                <button type="button" class="btn-secondary-modal" id="cancelEdit">Cancel</button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Hero Carousel Functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const indicators = document.querySelectorAll('.hero-indicator');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    
    slides[index].classList.add('active');
    indicators[index].classList.add('active');
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

// Auto-advance carousel
setInterval(nextSlide, 6000);

// Navigation controls
document.getElementById('nextSlide').addEventListener('click', nextSlide);
document.getElementById('prevSlide').addEventListener('click', prevSlide);

// Indicator controls
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentSlide = index;
        showSlide(currentSlide);
    });
});

// Notification banner smart display logic
function checkNotificationDisplay() {
    const storedDeadline = localStorage.getItem('applicationDeadline');
    const banner = document.getElementById('notificationBanner');
    
    if (storedDeadline) {
        const deadline = new Date(storedDeadline);
        const today = new Date();
        const oneMonthBefore = new Date(deadline);
        oneMonthBefore.setMonth(oneMonthBefore.getMonth() - 1);
        const oneDayAfter = new Date(deadline);
        oneDayAfter.setDate(oneDayAfter.getDate() + 1);
        
        if (today >= oneMonthBefore && today <= oneDayAfter) {
            banner.classList.remove('hidden');
            updateNotificationText(deadline);
        } else {
            banner.classList.add('hidden');
        }
    } else {
        // Default deadline for demonstration
        const defaultDeadline = new Date('2025-03-31');
        updateNotificationText(defaultDeadline);
    }
}

function updateNotificationText(deadline) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = deadline.toLocaleDateString('en-US', options);
    document.getElementById('notificationText').textContent = 
        `Applications for the upcoming semester are now open. Deadline: ${formattedDate}`;
}

function hideNotification() {
    document.getElementById('notificationBanner').classList.add('hidden');
}

// Advanced page loading with smooth transitions
window.addEventListener('load', function() {
    const loader = document.getElementById('pageLoader');
    setTimeout(() => {
        loader.classList.add('loaded');
        checkNotificationDisplay();
    }, 1000);
});

// Enhanced navbar scroll effects
let lastScrollY = window.scrollY;
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;
    
    if (currentScrollY > 100) {
        navbar.classList.add('scrolled');
        if (currentScrollY > lastScrollY && currentScrollY > 200) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
    } else {
        navbar.classList.remove('scrolled');
        navbar.style.transform = 'translateY(0)';
    }
    
    lastScrollY = currentScrollY;
});

// Mobile menu toggle with animations
const mobileToggle = document.getElementById('mobileToggle');
const navLinks = document.getElementById('navLinks');

mobileToggle.addEventListener('click', function() {
    this.classList.toggle('active');
    navLinks.classList.toggle('active');
    document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
});

// Smooth scrolling with offset for fixed navbar
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
            // Close mobile menu
            navLinks.classList.remove('active');
            mobileToggle.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

// Advanced intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Observe all animated elements
document.querySelectorAll('.animate-on-scroll, .timeline-item').forEach(el => {
    observer.observe(el);
});

// Animated counter for statistics
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 16);
    });
}

// Trigger counter animation when stats section is visible
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    statsObserver.observe(statsSection);
}

// Simple card hover effects
document.querySelectorAll('.enhanced-card, .feature-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)';
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
    });
});

// Parallax effect for hero background
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.hero-bg');
    if (parallax) {
        const speed = scrolled * 0.5;
        parallax.style.transform = `translateY(${speed}px)`;
    }
});

// Dynamic navigation highlighting
function updateActiveNavLink() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 150;
        if (window.scrollY >= sectionTop) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNavLink);

// Interactive timeline animations
const timelineItems = document.querySelectorAll('.timeline-item');
const timelineObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, index * 200);
        }
    });
}, { threshold: 0.3 });

timelineItems.forEach(item => {
    timelineObserver.observe(item);
});

// Modal functionality
const modal = document.getElementById('editModal');
const editBtn = document.getElementById('editBtn');
const closeModal = document.getElementById('closeModal');
const cancelEdit = document.getElementById('cancelEdit');
const editForm = document.getElementById('editForm');

// Open modal
editBtn?.addEventListener('click', function() {
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    // Load current values from storage
    const storedDeadline = localStorage.getItem('applicationDeadline');
    const storedPortalUrl = localStorage.getItem('applicationPortalUrl');
    
    if (storedDeadline) {
        document.getElementById('applicationDeadline').value = storedDeadline;
    }
    if (storedPortalUrl) {
        document.getElementById('applicationPortalUrl').value = storedPortalUrl;
    }
});

// Close modal
function closeEditModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

closeModal?.addEventListener('click', closeEditModal);
cancelEdit?.addEventListener('click', closeEditModal);

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        closeEditModal();
    }
});

// Handle form submission
editForm?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(editForm);
    
    // Update content on the page
    const heroTitle = formData.get('heroTitle');
    const heroSubtitle = formData.get('heroSubtitle');
    const introDescription = formData.get('introDescription');
    const aboutDescription = formData.get('aboutDescription');
    const applicationDeadline = formData.get('applicationDeadline');
    const applicationPortalUrl = formData.get('applicationPortalUrl');
    
    // Update text content
    if (heroTitle) {
        document.getElementById('heroTitle').textContent = heroTitle;
    }
    
    if (heroSubtitle) {
        document.getElementById('heroSubtitle').textContent = heroSubtitle;
    }
    
    if (introDescription) {
        document.getElementById('introDescription').textContent = introDescription;
    }
    
    if (aboutDescription) {
        document.getElementById('aboutDescription').textContent = aboutDescription;
    }
    
    // Store deadline and update notification
    if (applicationDeadline) {
        localStorage.setItem('applicationDeadline', applicationDeadline);
        checkNotificationDisplay();
    }
    
    // Update application portal URL
    if (applicationPortalUrl) {
        localStorage.setItem('applicationPortalUrl', applicationPortalUrl);
        document.getElementById('applicationPortalLink').href = applicationPortalUrl;
    }
    
    // Handle QR code image upload
    const qrCodeFile = formData.get('qrCodeImage');
    if (qrCodeFile && qrCodeFile.size > 0) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('qrCodeImage').src = e.target.result;
            localStorage.setItem('qrCodeImageData', e.target.result);
        };
        reader.readAsDataURL(qrCodeFile);
    }
    
    // Handle hero carousel image uploads (5 images)
    const heroImageInputs = ['heroImage1', 'heroImage2', 'heroImage3', 'heroImage4', 'heroImage5'];
    heroImageInputs.forEach((inputName, index) => {
        const file = formData.get(inputName);
        if (file && file.size > 0) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const slides = document.querySelectorAll('.hero-slide');
                if (slides[index]) {
                    slides[index].style.backgroundImage = `url(${e.target.result})`;
                    localStorage.setItem(`heroImage${index + 1}Data`, e.target.result);
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Handle other image uploads
    const otherImageInputs = ['introImage', 'aboutImage'];
    otherImageInputs.forEach(inputName => {
        const file = formData.get(inputName);
        if (file && file.size > 0) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (inputName === 'introImage') {
                    const introImg = document.querySelector('#introduction img');
                    if (introImg) {
                        introImg.src = e.target.result;
                        localStorage.setItem('introImageData', e.target.result);
                    }
                } else if (inputName === 'aboutImage') {
                    const aboutImg = document.querySelector('#about img');
                    if (aboutImg) {
                        aboutImg.src = e.target.result;
                        localStorage.setItem('aboutImageData', e.target.result);
                    }
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Show success message
    const successMsg = document.createElement('div');
    successMsg.innerHTML = `
        <div style="position: fixed; top: 100px; right: 20px; background: var(--gradient-primary); color: white; padding: 1rem 2rem; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); z-index: 3001; animation: slideInRight 0.3s ease;">
            <i class="fas fa-check-circle"></i> Content updated successfully!
        </div>
    `;
    document.body.appendChild(successMsg);
    setTimeout(() => successMsg.remove(), 3000);
    
    closeEditModal();
});

// Add CSS for active nav link
const style = document.createElement('style');
style.textContent = `
    .nav-links a.active {
        color: var(--primary-blue) !important;
    }
    .nav-links a.active::after {
        width: 100% !important;
    }
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth reveal for page elements
    const elements = document.querySelectorAll('.enhanced-card, .feature-card, .section-header');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        setTimeout(() => {
            el.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Initialize timeline items
    timelineItems.forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = 'all 0.6s ease';
    });
});

// Performance optimization - lazy loading for heavy elements
if ('IntersectionObserver' in window) {
    const lazyElements = document.querySelectorAll('[data-lazy]');
    const lazyObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                element.src = element.dataset.lazy;
                element.classList.remove('lazy');
                lazyObserver.unobserve(element);
            }
        });
    });
    
    lazyElements.forEach(el => lazyObserver.observe(el));
}

function loadStoredContent() {
    // Load stored portal URL
    const storedPortalUrl = localStorage.getItem('applicationPortalUrl');
    if (storedPortalUrl) {
        document.getElementById('applicationPortalLink').href = storedPortalUrl;
    }
    
    // Load stored QR code image
    const storedQRCode = localStorage.getItem('qrCodeImageData');
    if (storedQRCode) {
        document.getElementById('qrCodeImage').src = storedQRCode;
    }
    
    // Load stored hero carousel images
    for (let i = 1; i <= 5; i++) {
        const storedHeroImage = localStorage.getItem(`heroImage${i}Data`);
        if (storedHeroImage) {
            const slides = document.querySelectorAll('.hero-slide');
            if (slides[i - 1]) {
                slides[i - 1].style.backgroundImage = `url(${storedHeroImage})`;
            }
        }
    }
}

// Call this on page load
document.addEventListener('DOMContentLoaded', function() {
    loadStoredContent();
});

// Check notification display on page load
window.addEventListener('load', () => {
    setTimeout(checkNotificationDisplay, 1100);
});
</script>
</body>
</html>