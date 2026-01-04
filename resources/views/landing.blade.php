<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROTU NAVY UMS - Reserve Officer Training Unit</title>
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

        html {
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background-color: var(--darker-navy);
            color: var(--text-primary);
            line-height: 1.7;
            scroll-behavior: smooth;
            max-width: 100vw;
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
            height: clamp(40px, 10vw, 70px);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-text .main-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(0.95rem, 3vw, 1.75rem);
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.1;
            margin-bottom: clamp(0.15rem, 0.5vw, 0.25rem);
        }

        .nav-logo-text .sub-title {
            font-size: clamp(0.6rem, 1.5vw, 0.875rem);
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            letter-spacing: clamp(1px, 0.3vw, 2px);
            text-transform: uppercase;
            line-height: 1;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-links > li {
            position: relative;
        }

        .nav-links > li:not(:last-child):not(.user-dropdown)::after {
            content: '';
            position: absolute;
            right: -1.25rem;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 1px;
            background: linear-gradient(180deg, transparent 0%, rgba(60, 146, 217, 0.3) 50%, transparent 100%);
        }

        /* Remove separator before user dropdown if dashboard button exists */
        .nav-links > li:has(+ .user-dropdown)::after {
            display: none;
        }

        /* Reduce gap between dashboard button and user dropdown */
        .nav-links > li:has(+ .user-dropdown) {
            margin-right: -1.5rem;
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

        /* User Dropdown Styles */
        .user-dropdown {
            position: relative;
        }

        .user-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(60, 146, 217, 0.1);
            border: 1px solid rgba(60, 146, 217, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .user-dropdown-trigger:hover {
            background: rgba(60, 146, 217, 0.2);
            border-color: var(--primary-blue);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(60, 146, 217, 0.3);
        }

        .user-name {
            flex: 1;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100px;
        }

        .dropdown-arrow {
            font-size: 0.8rem;
            color: var(--text-secondary);
            transition: transform 0.3s ease;
        }

        .user-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 280px;
            background: var(--dark-navy);
            border: 1px solid rgba(60, 146, 217, 0.3);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            backdrop-filter: blur(20px);
        }

        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(60, 146, 217, 0.1);
        }

        .dropdown-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(60, 146, 217, 0.3);
        }

        .dropdown-user-info {
            flex: 1;
            min-width: 0;
        }

        .dropdown-user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropdown-user-email {
            font-size: 0.85rem;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(60, 146, 217, 0.1);
            margin: 0;
        }

        .dropdown-items {
            padding: 0.5rem;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            background: none;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .dropdown-item:hover {
            background: rgba(60, 146, 217, 0.1);
            color: var(--text-primary);
        }

        .dropdown-item.logout-item:hover {
            background: rgba(236, 108, 108, 0.1);
            color: var(--accent-pink);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Mobile and Desktop Visibility */
        .desktop-only {
            display: block;
        }

        .mobile-only {
            display: none;
        }

        /* Mobile Top Section - Enhanced */
        .mobile-top-section {
            order: -1;
            width: 100%;
            padding: 0 !important;
            margin-bottom: 1.5rem;
            animation: fadeInDown 0.5s ease-out 0.1s both;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-profile-dashboard-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(60, 146, 217, 0.08) 0%, rgba(60, 146, 217, 0.03) 100%);
            border-radius: 16px;
            border: 1.5px solid rgba(60, 146, 217, 0.2);
            width: 100%;
            box-shadow: 0 4px 16px rgba(60, 146, 217, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .mobile-profile-dashboard-row:hover {
            border-color: rgba(60, 146, 217, 0.3);
            box-shadow: 0 6px 20px rgba(60, 146, 217, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .mobile-profile-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        .mobile-profile-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(60, 146, 217, 0.4);
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.2), 0 0 0 4px rgba(60, 146, 217, 0.1);
            transition: all 0.3s ease;
        }

        .mobile-profile-avatar:hover {
            transform: scale(1.05);
            border-color: rgba(60, 146, 217, 0.6);
            box-shadow: 0 6px 16px rgba(60, 146, 217, 0.3), 0 0 0 4px rgba(60, 146, 217, 0.15);
        }

        .mobile-profile-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mobile-profile-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            letter-spacing: 0.01em;
        }

        .mobile-profile-email {
            font-size: 0.8rem;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            font-weight: 400;
        }

        /* Mobile Action Buttons Container */
        .mobile-action-buttons {
            display: flex;
            gap: 0.625rem;
            flex-shrink: 0;
            align-items: center;
        }

        .mobile-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        .mobile-action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease;
        }

        .mobile-action-btn:active::before {
            width: 100px;
            height: 100px;
        }

        .mobile-dashboard-btn {
            background: var(--gradient-primary);
            box-shadow: 0 4px 12px rgba(60, 146, 217, 0.35), 0 2px 4px rgba(60, 146, 217, 0.2);
        }

        .mobile-dashboard-btn:hover {
            background: linear-gradient(135deg, #2980b9, #3c92d9);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 18px rgba(60, 146, 217, 0.45), 0 3px 6px rgba(60, 146, 217, 0.25);
        }

        .mobile-dashboard-btn:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 2px 8px rgba(60, 146, 217, 0.3);
        }

        .mobile-edit-btn {
            background: linear-gradient(135deg, #ec6c6c, #d64545);
            box-shadow: 0 4px 12px rgba(236, 108, 108, 0.35), 0 2px 4px rgba(236, 108, 108, 0.2);
        }

        .mobile-edit-btn:hover {
            background: linear-gradient(135deg, #d64545, #b83838);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 18px rgba(236, 108, 108, 0.45), 0 3px 6px rgba(236, 108, 108, 0.25);
        }

        .mobile-edit-btn:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 2px 8px rgba(236, 108, 108, 0.3);
        }

        .mobile-section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(60, 146, 217, 0.2) 50%, transparent 100%);
            margin-top: 1.25rem;
            width: 100%;
            position: relative;
        }

        .mobile-section-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: rgba(60, 146, 217, 0.3);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(60, 146, 217, 0.4);
        }

        /* Mobile Navigation Items */
        .nav-mobile-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            width: 100%;
            padding: 1rem 1.25rem;
            background: none;
            border: none;
            color: var(--text-secondary);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            font-weight: 500;
            border-radius: 12px;
            margin: 0.25rem 0;
            position: relative;
            overflow: hidden;
        }

        .nav-mobile-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--gradient-primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .nav-mobile-item:hover {
            color: var(--primary-blue);
            background: rgba(60, 146, 217, 0.1);
            transform: translateX(8px);
        }

        .nav-mobile-item:hover::before {
            transform: scaleY(1);
        }

        .nav-mobile-item:active {
            transform: translateX(4px) scale(0.98);
        }

        .nav-mobile-item i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-mobile-item:hover i {
            transform: scale(1.15);
        }

        .mobile-logout-btn {
            margin-top: 0.5rem;
        }

        .mobile-logout-btn:hover {
            color: var(--accent-pink) !important;
            background: rgba(236, 108, 108, 0.1) !important;
        }

        .mobile-logout-btn:hover::before {
            background: linear-gradient(135deg, #ec6c6c, #d64545);
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
            position: fixed;
            top: 81px;
            left: 0;
            right: 0;
            width: 100%;
            background: var(--gradient-primary);
            padding: clamp(0.875rem, 2vw, 1.25rem) clamp(2.5rem, 8vw, 4rem) clamp(0.875rem, 2vw, 1.25rem) clamp(1rem, 3vw, 2rem);
            text-align: center;
            border-bottom: 2px solid rgba(60, 146, 217, 0.3);
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 1500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .notification-banner.hidden {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .notification-banner h3 {
            font-size: clamp(0.95rem, 2.5vw, 1.2rem);
            margin-top: clamp(0.5rem, 1.5vw, 0.65rem);
            margin-bottom: clamp(0.15rem, 0.5vw, 0.25rem);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(0.375rem, 1vw, 0.5rem);
            line-height: 1.4;
        }

        .notification-banner h3 i {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
        }

        .notification-banner p {
            font-size: clamp(0.8rem, 2vw, 1rem);
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            line-height: 1.5;
            padding: 0 clamp(0.5rem, 2vw, 1rem);
        }

        .notification-close {
            position: absolute;
            right: clamp(0.75rem, 3vw, 2rem);
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: clamp(1rem, 2.5vw, 1.5rem);
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            z-index: 10;
            padding: clamp(0.25rem, 1vw, 0.5rem);
        }

        .notification-close:hover {
            opacity: 1;
        }

        /* Hero Section with Image Carousel */
        .hero-section {
            position: relative;
            height: 100vh;
            margin-top: 80px;
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
            bottom: clamp(15px, 4vw, 30px);
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: clamp(8px, 2vw, 12px);
            z-index: 15;
        }

        .hero-indicator {
            width: clamp(8px, 2vw, 12px);
            height: clamp(8px, 2vw, 12px);
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
            width: clamp(36px, 8vw, 50px);
            height: clamp(36px, 8vw, 50px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 15;
            font-size: clamp(0.9rem, 2vw, 1.2rem);
        }

        .hero-carousel-nav:hover {
            background: var(--primary-blue);
            transform: translateY(-50%) scale(1.1);
        }

        .hero-carousel-nav.prev {
            left: clamp(10px, 3vw, 30px);
        }

        .hero-carousel-nav.next {
            right: clamp(10px, 3vw, 30px);
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 1000px;
            padding: 0 2rem;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 6vw, 5.5rem);
            font-weight: 700;
            margin-bottom: clamp(0.75rem, 3vw, 1.5rem);
            background: linear-gradient(135deg, var(--text-primary), var(--primary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease 0.4s both;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(0.95rem, 2.5vw, 1.75rem);
            color: var(--text-secondary);
            margin-bottom: clamp(1.5rem, 5vw, 3rem);
            animation: fadeInUp 1s ease 0.6s both;
            font-weight: 400;
            line-height: 1.5;
        }

        .hero-cta {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease 0.8s both;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 12px 28px;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
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
            border-color: var(--primary-blue);
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
            font-size: clamp(1.5rem, 4vw, 2rem);
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
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: clamp(0.25rem, 1vw, 0.5rem);
            display: block;
        }

        .stat-label {
            font-size: clamp(0.85rem, 2vw, 1rem);
            color: var(--text-secondary);
            font-weight: 500;
            line-height: 1.4;
        }

        /* Enhanced Sections */
        .section {
            padding: clamp(3rem, 8vw, 6rem) clamp(1rem, 3vw, 2rem);
            position: relative;
        }

        .section-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(0.5rem, 2vw, 1rem);
        }

        .section-header {
            text-align: center;
            margin-bottom: clamp(2rem, 5vw, 4rem);
        }

        .section-badge {
            display: inline-block;
            background: rgba(60, 146, 217, 0.1);
            border: 1px solid var(--primary-blue);
            padding: clamp(4px, 1vw, 6px) clamp(12px, 3vw, 16px);
            border-radius: 50px;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            color: var(--primary-blue);
            margin-bottom: clamp(0.75rem, 2vw, 1rem);
            font-weight: 500;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.75rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: clamp(0.75rem, 3vw, 1.5rem);
            color: var(--text-primary);
            line-height: 1.2;
        }

        .section-description {
            font-size: clamp(0.95rem, 2.5vw, 1.125rem);
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Enhanced Cards */
        .enhanced-card {
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: clamp(1.5rem, 5vw, 3rem);
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

        @media (hover: hover) {
            .enhanced-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 25px 60px rgba(60, 146, 217, 0.2);
                border-color: rgba(60, 146, 217, 0.3);
            }
        }

        /* Interactive Timeline with Zig-Zag Layout - Forced Visibility */
        .timeline {
            position: relative;
            margin: 4rem 0;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
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
            z-index: 1;
        }

        .timeline-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6rem 0;
            position: relative;
        }

        .timeline-item {
            position: relative;
            width: 45%;
            opacity: 1 !important;
            transform: translateY(0) !important;
            transition: all 0.6s ease;
            display: block !important;
            visibility: visible !important;
        }

        .timeline-left {
            text-align: right;
        }

        .timeline-right {
            text-align: left;
        }

        .timeline-content,
        .timeline-video-content {
            background: rgba(60, 146, 217, 0.1);
            border-radius: 16px;
            padding: clamp(1.5rem, 4vw, 2.5rem);
            position: relative;
            border: 2px solid var(--border-color);
            overflow: hidden;
            aspect-ratio: 16/9;
            cursor: pointer;
            transition: all 0.4s ease;
            z-index: 5;
            display: flex !important;
            align-items: center;
            justify-content: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .timeline-video-content {
            padding: 0;
        }

        .timeline-content:hover,
        .timeline-video-content:hover {
            transform: translateY(-8px);
            border-color: var(--primary-blue);
            box-shadow: 0 20px 50px rgba(60, 146, 217, 0.3);
        }

        .timeline-content-inner {
            width: 100%;
            text-align: center;
            z-index: 2;
            position: relative;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .timeline-content h3 {
            font-size: 1.6rem;
        }

        .timeline-content p {
            font-size: 1rem;
            line-height: 1.7;
        }

        .timeline-icon {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: clamp(50px, 10vw, 70px);
            height: clamp(50px, 10vw, 70px);
            min-width: clamp(50px, 10vw, 70px);
            min-height: clamp(50px, 10vw, 70px);
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.25rem, 3vw, 1.8rem);
            color: white;
            border: clamp(4px, 1vw, 6px) solid var(--dark-navy);
            z-index: 10;
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
            transition: all 0.3s ease;
            opacity: 1 !important;
            visibility: visible !important;
            flex-shrink: 0;
        }

        @media (hover: hover) {
            .timeline-item:hover .timeline-icon {
                transform: translate(-50%, -50%) scale(1.1);
                box-shadow: 0 12px 35px rgba(60, 146, 217, 0.6);
            }
        }

        .timeline-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
            aspect-ratio: 16/9;
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .video-fallback {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-align: center;
            padding: clamp(1.5rem, 4vw, 2rem);
            height: 100%;
            aspect-ratio: 16/9;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .video-fallback p {
            margin: 0;
            font-size: clamp(0.95rem, 2.5vw, 1.1rem);
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Center Timeline Icons */
        .timeline-center-icon {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: clamp(50px, 10vw, 70px);
            height: clamp(50px, 10vw, 70px);
            min-width: clamp(50px, 10vw, 70px);
            min-height: clamp(50px, 10vw, 70px);
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.25rem, 3vw, 1.8rem);
            color: white;
            border: clamp(4px, 1vw, 6px) solid var(--dark-navy);
            z-index: 10;
            box-shadow: 0 8px 25px rgba(60, 146, 217, 0.4);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .timeline-center-icon:hover {
            transform: translateX(-50%) scale(1.1);
            box-shadow: 0 12px 35px rgba(60, 146, 217, 0.6);
        }

        /* Force visibility for all timeline elements */
        .timeline * {
            opacity: 1 !important;
            visibility: visible !important;
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
            padding: clamp(2rem, 5vw, 3.5rem);
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

        @media (hover: hover) {
            .feature-card:hover {
                transform: translateY(-8px);
                border-color: var(--primary-blue);
                box-shadow: 0 20px 40px rgba(60, 146, 217, 0.15);
            }
        }

        .feature-icon {
            width: clamp(55px, 12vw, 80px);
            height: clamp(55px, 12vw, 80px);
            min-width: clamp(55px, 12vw, 80px);
            min-height: clamp(55px, 12vw, 80px);
            background: var(--gradient-primary);
            border-radius: clamp(12px, 3vw, 16px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.5rem, 3vw, 2rem);
            color: white;
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        @media (hover: hover) {
            .feature-card:hover .feature-icon {
                transform: scale(1.1) rotate(5deg);
                background: var(--gradient-accent);
            }
        }

        .feature-title {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            font-weight: 700;
            margin-bottom: clamp(0.75rem, 2vw, 1rem);
            color: var(--text-primary);
            line-height: 1.3;
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: clamp(0.9rem, 2vw, 1rem);
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
            padding: clamp(1.5rem, 4vw, 2rem);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        @media (hover: hover) {
            .requirement-card:hover {
                transform: translateY(-8px);
                border-color: var(--primary-blue);
                box-shadow: 0 20px 40px rgba(60, 146, 217, 0.15);
            }
        }

        .requirement-card h3 {
            color: var(--primary-blue);
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            margin-bottom: clamp(0.75rem, 2vw, 1rem);
            text-align: center;
            border-bottom: 2px solid var(--primary-blue);
            padding-bottom: clamp(0.375rem, 1vw, 0.5rem);
        }

        .requirement-card ul {
            list-style: none;
            padding: 0;
        }

        .requirement-card li {
            padding: clamp(0.375rem, 1vw, 0.5rem) 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            padding-left: clamp(1.25rem, 3vw, 1.5rem);
            font-size: clamp(0.9rem, 2vw, 1rem);
            line-height: 1.5;
        }

        .requirement-card li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary-blue);
            font-weight: bold;
        }

        .requirement-card li.no-tick::before {
            content: none;
        }

        /* Modal Styles */
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

        /* Logout Modal Buttons */
        #logoutModal .modal-buttons {
            display: flex !important;
            gap: 1rem !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 2rem !important;
            padding-top: 1rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            flex-direction: row !important;
        }

        #logoutModal .modal-buttons form {
            display: inline !important;
            margin: 0 !important;
            flex: 1 !important;
            max-width: 120px !important;
        }

        #logoutModal .btn-secondary-modal,
        #logoutModal .btn-primary {
            width: 100% !important;
            min-width: 100px !important;
            text-align: center !important;
            padding: 12px 16px !important;
            font-size: 0.95rem !important;
        }

        #logoutModal .btn-secondary-modal {
            flex: 1 !important;
            max-width: 120px !important;
        }

        /* QR Code Container */
        .qr-code-container {
            width: 280px;
            height: 280px;
            background: white;
            margin: 0 auto 2rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .qr-code-container img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
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
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
            font-size: clamp(1.1rem, 3vw, 1.25rem);
            font-weight: 600;
        }

        .footer-section p, .footer-section li {
            color: var(--text-secondary);
            margin-bottom: clamp(0.5rem, 1.5vw, 0.75rem);
            transition: color 0.3s ease;
            font-size: clamp(0.9rem, 2vw, 1rem);
            line-height: 1.6;
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
            gap: clamp(0.75rem, 2vw, 1rem);
            margin-top: clamp(0.75rem, 2vw, 1rem);
            flex-wrap: wrap;
        }

        .social-icon {
            width: clamp(44px, 10vw, 50px);
            height: clamp(44px, 10vw, 50px);
            min-width: clamp(44px, 10vw, 50px);
            min-height: clamp(44px, 10vw, 50px);
            background: rgba(60, 146, 217, 0.1);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        @media (hover: hover) {
            .social-icon:hover {
                background: var(--gradient-primary);
                color: white;
                transform: translateY(-3px);
                border-color: var(--primary-blue);
            }
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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Navigation Active States */
        .nav-links a.active {
            color: var(--primary-blue) !important;
        }

        .nav-links a.active::after {
            width: 100% !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            /* Navigation responsiveness */
            .navbar {
                padding: 0.75rem 1rem;
            }

            .navbar.scrolled {
                padding: 0.5rem 1rem;
            }

            .nav-logo img {
                height: 50px;
            }

            .nav-logo-text .main-title {
                font-size: 1.25rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.7rem;
                letter-spacing: 1px;
            }

            .user-dropdown-menu {
                width: calc(100vw - 2rem);
                max-width: 320px;
                right: 0;
                left: auto;
            }

            .nav-links {
                display: none;
                position: fixed;
                top: 70px;
                right: -100%;
                width: 85%;
                max-width: 320px;
                height: calc(100vh - 70px);
                background: linear-gradient(180deg, rgba(16, 20, 28, 0.98) 0%, rgba(16, 20, 28, 0.96) 100%);
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                flex-direction: column;
                padding: 1rem 1.25rem;
                gap: 0;
                border-left: 1px solid rgba(60, 146, 217, 0.2);
                box-shadow: -4px 0 24px rgba(0, 0, 0, 0.3);
                overflow-y: auto;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 999;
            }

            .nav-links.active {
                display: flex;
                right: 0;
                animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            @keyframes slideInRight {
                from {
                    right: -100%;
                    opacity: 0.8;
                }
                to {
                    right: 0;
                    opacity: 1;
                }
            }

            .nav-links.active li {
                padding-left: 0;
                width: 100%;
                animation: fadeSlideIn 0.4s ease-out backwards;
                position: relative;
            }

            /* Hide desktop vertical separators on mobile */
            .nav-links > li::after {
                display: none !important;
            }

            /* Add horizontal separators for mobile navigation items */
            .nav-links.active > li:not(:last-child) {
                border-bottom: 1px solid rgba(60, 146, 217, 0.2);
                margin-bottom: 0.25rem;
                padding-bottom: 0.25rem;
            }

            .nav-links.active li:nth-child(1) { animation-delay: 0.05s; }
            .nav-links.active li:nth-child(2) { animation-delay: 0.1s; }
            .nav-links.active li:nth-child(3) { animation-delay: 0.15s; }
            .nav-links.active li:nth-child(4) { animation-delay: 0.2s; }
            .nav-links.active li:nth-child(5) { animation-delay: 0.25s; }
            .nav-links.active li:nth-child(6) { animation-delay: 0.3s; }
            .nav-links.active li:nth-child(7) { animation-delay: 0.35s; }
            .nav-links.active li:nth-child(8) { animation-delay: 0.4s; }
            .nav-links.active li:nth-child(9) { animation-delay: 0.45s; }
            .nav-links.active li:nth-child(10) { animation-delay: 0.5s; }

            @keyframes fadeSlideIn {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .nav-links > li > a {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                margin: 0.15rem 0;
                border-radius: 12px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                font-weight: 500;
                font-size: 1rem;
                position: relative;
                overflow: hidden;
            }

            .nav-links > li > a::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 4px;
                background: var(--gradient-primary);
                transform: scaleY(0);
                transition: transform 0.3s ease;
                border-radius: 0 4px 4px 0;
            }

            .nav-links > li > a:hover {
                background: rgba(60, 146, 217, 0.15);
                transform: translateX(8px);
                color: var(--primary-blue);
            }

            .nav-links > li > a:hover::before {
                transform: scaleY(1);
            }

            .nav-links > li > a:active {
                transform: translateX(4px) scale(0.98);
            }

            .mobile-menu-toggle {
                display: flex;
                position: relative;
                z-index: 1000;
            }

            .desktop-only {
                display: none;
            }

            .mobile-only {
                display: block;
            }

            .nav-links.active .mobile-top-section {
                display: block;
                order: -1;
            }

            .nav-links.active .mobile-only {
                display: block;
            }

            /* Mobile Login Button Styling */
            .nav-links.active .mobile-only .btn-primary {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0 0 0.5rem 0;
                padding: 0.875rem 1.5rem;
                font-size: 1.05rem;
            }

            /* Mobile Navigation Overlay */
            .nav-overlay {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                height: calc(100vh - 70px);
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.4s ease, visibility 0.4s ease;
                z-index: 998;
            }

            .nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Notification banner */
            .notification-banner {
                padding: 1rem 3rem 1rem 1rem;
                font-size: 0.85rem;
            }

            /* Hero section */
            .hero-section {
                height: 70vh;
            }

            .hero-content {
                padding: 2rem 1.5rem;
                max-width: 90%;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .hero-content p {
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }

            .hero-cta {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .hero-cta .btn-primary {
                width: 100%;
                max-width: 300px;
                text-align: center;
                justify-content: center;
            }

            .carousel-nav {
                width: 44px;
                height: 44px;
                font-size: 1rem;
            }

            .carousel-nav.prev {
                left: 15px;
            }

            .carousel-nav.next {
                right: 15px;
            }

            /* Statistics */
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            /* Features and Requirements */
            .features-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem;
            }

            .feature-card {
                padding: 2.5rem 2rem;
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                font-size: 1.75rem;
            }

            .requirements-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem;
            }

            /* Sections */
            .section {
                padding: 4rem 1rem;
            }

            .enhanced-card {
                padding: 2rem;
            }

            .application-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }

            .footer-content {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }

            .footer-section {
                padding: 0;
                margin-bottom: 1rem;
            }

            .footer-section h3 {
                text-align: center;
            }

            .footer-section iframe {
                height: 150px !important;
            }

            .footer-section .social-icons {
                justify-content: center;
            }

            .intro-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }

            .intro-grid .enhanced-card img {
                height: 200px !important;
            }

            .intro-grid .enhanced-card h3 {
                font-size: 1.25rem !important;
            }

            .intro-grid .enhanced-card {
                padding: 1.5rem !important;
            }

            .timeline::before {
                left: 30px;
            }
            
            .timeline-row {
                flex-direction: column;
                gap: 3rem;
            }
            
            .timeline-item {
                width: calc(100% - 80px) !important;
                margin-left: 80px;
                text-align: left;
            }
            
            .timeline-center-icon {
                left: 30px !important;
                transform: translateX(-50%) !important;
            }
            
            .timeline-center-icon:hover {
                transform: translateX(-50%) scale(1.1) !important;
            }
            
            .timeline-center-icon:nth-child(1) { top: 10% !important; }
            .timeline-center-icon:nth-child(3) { top: 35% !important; }
            .timeline-center-icon:nth-child(5) { top: 60% !important; }
            .timeline-center-icon:nth-child(7) { top: 85% !important; }

            .timeline-content h3 {
                font-size: 1.2rem !important;
            }

            .timeline-content p {
                font-size: 0.8rem !important;
                line-height: 1.5 !important;
            }

            .modal-content {
                width: 95%;
                margin: 5% auto;
                padding: 1.5rem;
            }
            
            .modal-buttons {
                flex-direction: column;
            }
            
            .modal-buttons button {
                width: 100%;
            }

            #logoutModal .modal-buttons {
                flex-direction: row !important;
                gap: 0.75rem !important;
            }
            
            #logoutModal .btn-secondary-modal,
            #logoutModal .btn-primary {
                font-size: 0.9rem !important;
                padding: 10px 12px !important;
                min-width: 80px !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-top-section {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            /* Extra small devices - Honor X9a and smaller */

            /* Navigation */
            .navbar {
                padding: 0.5rem 0.75rem;
            }

            .navbar.scrolled {
                padding: 0.5rem 0.75rem;
            }

            .nav-logo img {
                height: 45px;
            }

            .nav-logo-text .main-title {
                font-size: 1.1rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.65rem;
            }

            .user-dropdown-menu {
                width: calc(100vw - 1.5rem);
                max-width: 300px;
            }

            .user-dropdown-trigger {
                min-width: 120px;
                padding: 6px 10px;
                font-size: 0.85rem;
            }

            .user-avatar {
                width: 28px;
                height: 28px;
            }

            /* Notification banner */
            .notification-banner {
                padding: 0.875rem 2.5rem 0.875rem 0.875rem;
                font-size: 0.8rem;
            }

            .notification-close {
                right: 0.75rem;
                width: 28px;
                height: 28px;
                font-size: 1rem;
            }

            /* Statistics - single column */
            .stats-container {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .stat-label {
                font-size: 0.95rem;
            }

            /* Features */
            .feature-card {
                padding: 2rem 1.5rem;
            }

            .feature-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }

            /* Requirements */
            .requirement-card {
                padding: 2rem 1.5rem;
            }

            /* Sections */
            .section {
                padding: 3rem 1rem;
            }

            .section-title {
                font-size: 2rem;
                margin-bottom: 2rem;
            }

            .section-subtitle {
                font-size: 1rem;
            }

            .enhanced-card {
                padding: 1.5rem;
            }

            /* Hero */
            .hero-section {
                height: 60vh;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            /* Timeline */
            .timeline::before {
                left: 20px;
            }

            .timeline-item {
                width: calc(100% - 60px) !important;
                margin-left: 60px;
                padding: 1.5rem;
            }

            .timeline-center-icon {
                left: 20px !important;
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .timeline-content {
                min-height: auto;
            }

            .timeline-content h3 {
                font-size: 0.7rem !important;
                margin-bottom: 0.4rem !important;
            }

            .timeline-content p {
                font-size: 0.55rem !important;
                line-height: 1.15 !important;
            }

            /* Application section - QR code */
            .qr-code-container {
                width: 240px;
                height: 240px;
            }

            /* Footer */
            .footer-section .social-icons a {
                width: 44px;
                height: 44px;
                font-size: 1.25rem;
            }

            /* Modals */
            .modal-content {
                width: 96%;
                margin: 2% auto;
                padding: 1.25rem;
            }

            #logoutModal .modal-buttons {
                flex-direction: row !important;
                gap: 0.75rem !important;
            }

            #logoutModal .btn-secondary-modal,
            #logoutModal .btn-primary {
                font-size: 0.85rem !important;
                padding: 9px 10px !important;
                min-width: 75px !important;
            }
        }

        /* Extra small devices - specific adjustments for 360px screens */
        @media (max-width: 360px) {
            .nav-logo img {
                height: 40px;
            }

            .nav-logo-text .main-title {
                font-size: 1rem;
            }

            .nav-logo-text .sub-title {
                font-size: 0.6rem;
            }

            .user-dropdown-menu {
                width: calc(100vw - 1rem);
            }

            .section-title {
                font-size: 1.75rem;
            }

            .feature-card,
            .requirement-card {
                padding: 1.5rem 1.25rem;
            }

            .qr-code-container {
                width: 220px;
                height: 220px;
            }
        }

        /* Intermediate breakpoint for better tablet responsiveness */
        @media (max-width: 600px) {
            .hero-content {
                padding: clamp(1rem, 4vw, 2rem);
            }

            .hero-content h1 {
                font-size: clamp(1.5rem, 5vw, 2.5rem);
            }

            .hero-cta {
                gap: 1rem;
            }

            .btn-primary, .btn-secondary {
                padding: clamp(0.6rem, 2vw, 0.75rem) clamp(1.5rem, 4vw, 2rem);
                font-size: clamp(0.9rem, 2vw, 1rem);
            }

            .stats-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .features-grid, .requirements-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .notification-banner {
                padding: 0.75rem 2.5rem 0.75rem 1rem;
            }

            .notification-banner h3 {
                font-size: clamp(0.95rem, 2.5vw, 1.1rem);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#home" class="nav-logo" id="logoLink">
                <img src="storage/assets/logo/PSS-LOGO.png" alt="Logo ROTU">
                <div class="nav-logo-text">
                    <span class="main-title">PALAPES</span>
                    <span class="sub-title">LAUT UMS</span>
                </div>
            </a>
            <ul class="nav-links" id="navLinks">
                <!-- Authentication-based navigation -->
                @auth
                    <!-- Mobile navigation items are in different order than desktop -->
                @else
                    <!-- Login button - First item on mobile, last on desktop -->
                    <li class="mobile-only" style="order: -1;"><a href="{{ route('login') }}" class="btn-primary">Login</a></li>
                @endauth

                <li><a href="#introduction">Pengenalan</a></li>
                <li><a href="#timeline">Perjalanan</a></li>
                <li><a href="#about">Mengenai</a></li>
                <li><a href="#benefits">Faedah</a></li>
                <li><a href="#requirements">Syarat</a></li>
                <li><a href="#selection">Pemilihan</a></li>
                <li><a href="#application">Mohon</a></li>
                <li><a href="#gallery">Galeri</a></li>

                @auth
                    @php
                        $dashboardRoute = match (auth()->user()->role) {
                            'cadet' => 'cadet.dashboard',
                            'instructor' => 'instructor.dashboard',
                            'admin' => 'admin.dashboard',
                            default => null
                        };
                        
                        $user = Auth::user();
                        $profilePicture = null;

                        if ($user->role === 'instructor') {
                            $instructor = App\Models\Instructor::where('user_id', $user->id)->first();
                            $profilePicture = $instructor?->profile_pic;
                        } elseif ($user->role === 'cadet') {
                            $cadet = App\Models\Cadet::where('user_id', $user->id)->first();
                            $profilePicture = $cadet?->profile_pic;
                        }

                        $avatarSrc = $profilePicture 
                            ? asset('storage/' . $profilePicture) 
                            : asset('images/default.png');
                    @endphp
                    
                    <!-- Desktop Dashboard Button -->
                    @if($dashboardRoute)
                        <li class="desktop-only"><a href="{{ route($dashboardRoute) }}" class="btn-primary">Dashboard</a></li>
                    @endif
                    
                    <!-- Desktop User Dropdown -->
                    <li class="user-dropdown desktop-only">
                        <button class="user-dropdown-trigger" id="userDropdownTrigger">
                            <img src="{{ $avatarSrc }}" alt="Profil" class="user-avatar" onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </button>
                        
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="dropdown-header">
                                <img src="{{ $avatarSrc }}" alt="Profil" class="dropdown-avatar" onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
                                <div class="dropdown-user-info">
                                    <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                                    <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            
                            <div class="dropdown-divider"></div>
                            
                            <div class="dropdown-items">
                                @if(auth()->user()->role === 'instructor')
                                    <button type="button" class="dropdown-item" id="editPageBtn">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit Page</span>
                                    </button>
                                @endif
                                
                                <button type="button" class="dropdown-item logout-item" id="dropdownLogoutBtn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Mobile Profile and Action Buttons Row (at top of mobile menu) -->
                    <li class="mobile-only mobile-top-section">
                        <div class="mobile-profile-dashboard-row">
                            <!-- Profile Section -->
                            <div class="mobile-profile-section">
                                <img src="{{ $avatarSrc }}" alt="Profil" class="mobile-profile-avatar" onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
                                <div class="mobile-profile-info">
                                    <div class="mobile-profile-name">{{ Auth::user()->name }}</div>
                                    <div class="mobile-profile-email">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mobile-action-buttons">
                                @if($dashboardRoute)
                                    <button type="button" class="mobile-action-btn mobile-dashboard-btn" onclick="window.location.href='{{ route($dashboardRoute) }}'">
                                        <i class="fas fa-tachometer-alt"></i>
                                    </button>
                                @endif
                                
                                @if(auth()->user()->role === 'instructor')
                                    <button type="button" class="mobile-action-btn mobile-edit-btn" id="mobileEditPageBtn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="mobile-section-divider"></div>
                    </li>
                    
                    <!-- Mobile Log Out Button -->
                    <li class="mobile-only">
                        <button type="button" class="nav-mobile-item mobile-logout-btn" id="mobileLogoutBtn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </li>

                @else
                    <!-- Login button for desktop - hidden on mobile since it's shown at top -->
                    <li class="desktop-only"><a href="{{ route('login') }}" class="btn-primary">Login</a></li>
                @endauth
            </ul>
            
            <div class="mobile-menu-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Overlay -->
    <div class="nav-overlay" id="navOverlay"></div>

    <!-- Notification Banner -->
        @if(\App\Models\ContentSetting::shouldShowDeadlineBanner())
        <section class="notification-banner" id="notificationBanner">
            <h3 id="notificationTitle">
                <i class="fas fa-bullhorn"></i>
                Permohonan Pengambilan Seterusnya Dibuka!
            </h3>
            <p id="notificationText">Permohonan untuk semester akan datang kini dibuka. Tarikh Tutup: {{ \App\Models\ContentSetting::getFormattedDeadline() }}</p>
            <button class="notification-close" id="closeNotification" onclick="hideNotification()">
                <i class="fas fa-times"></i>
            </button>
        </section>
        @endif

    <!-- Hero Section -->
        <section id="home" class="hero-section">
            <div class="hero-carousel" id="heroCarousel">
                <div class="hero-slide active" style="background-image: url('{{ asset('storage/assets/carousel/berenang.jpeg') }}')"></div>
                <div class="hero-slide" style="background-image: url('{{ asset('storage/assets/carousel/menembak.jpeg') }}')"></div>
                <div class="hero-slide" style="background-image: url('{{ asset('storage/assets/carousel/bot.jpeg') }}')"></div>
                <div class="hero-slide" style="background-image: url('{{ asset('storage/assets/carousel/kawad.jpeg') }}')"></div>
                <div class="hero-slide" style="background-image: url('{{ asset('storage/assets/carousel/kapal.jpeg') }}')"></div>
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
                <h1 class="hero-title" id="heroTitle">{{ \App\Models\ContentSetting::get('hero_title', 'Kecemerlangan dalam Kepimpinan Maritim') }}</h1>
                <p class="hero-subtitle" id="heroSubtitle">{{ \App\Models\ContentSetting::get('hero_subtitle', 'Bentuk laluan anda sebagai pegawai tentera laut melalui latihan komprehensif, pembangunan kepimpinan, dan kecemerlangan akademik di Universiti Malaysia Sabah') }}</p>
                <div class="hero-cta">
                    <a href="#application" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Mohon Sekarang
                    </a>
                    <a href="#introduction" class="btn-secondary">
                        <i class="fas fa-info-circle"></i> Ketahui Lebih Lanjut
                    </a>
                </div>
            </div>
        </section>

    <!-- Statistics Section -->
    <section class="stats-section" style="background: linear-gradient(135deg, rgba(16, 20, 28, 0.95), rgba(60, 146, 217, 0.1));">
        <div class="stats-container">
            <div class="stat-item animate-on-scroll">
                <span class="stat-number" data-count="500">0</span>
                <span class="stat-label">Jumlah Keseluruhan Kadet Palapes</span>
            </div>
            <div class="stat-item animate-on-scroll">
                <span class="stat-number" data-count="11">0</span>
                <span class="stat-label">Intake Ditauliahkan</span>
            </div>
            <div class="stat-item animate-on-scroll">
                <span class="stat-number" data-count="95">0</span>
                <span class="stat-label">% Kadet Ditauliahkan</span>
            </div>
            <div class="stat-item animate-on-scroll">
                <span class="stat-number" data-count="120">0</span>
                <span class="stat-label">Kadet Aktif</span>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section id="introduction" class="section">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Gambaran Keseluruhan Program</div>
                <h2 class="section-title">Mengenai PALAPES Laut UMS</h2>
                <p class="section-description" id="introDescription">
                    Pasukan Latihan Pegawai Simpanan (PALAPES) mewakili program pembangunan kepimpinan tentera laut terkemuka Malaysia, menggabungkan kecemerlangan akademik yang ketat dengan latihan ketenteraan yang komprehensif untuk membentuk generasi akan datang pemimpin maritim.
                </p>
            </div>
            
            <div class="intro-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 4rem;">
                <div class="enhanced-card animate-on-scroll">
                    <img src="storage/assets/images/intake11.jpeg" alt="Latihan PALAPES" style="width: 100%; height: 300px; object-fit: cover; border-radius: 12px; margin-bottom: 2rem;">
                    <h3 style="color: var(--primary-blue); margin-bottom: 1rem; font-size: 1.5rem;">Misi Kami</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6;">
                        Untuk membangunkan pemimpin maritim yang luar biasa melalui latihan komprehensif yang menggabungkan kecemerlangan akademik, disiplin ketenteraan, dan pembangunan sahsiah, menyediakan graduan untuk berkhidmat dengan kehormatan dalam pasukan tentera laut Malaysia dan sektor awam.
                    </p>
                </div>

                <div class="enhanced-card animate-on-scroll">
                    <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.5rem;">Sorotan Program</h3>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 50px; height: 50px; min-width: 50px; min-height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-graduation-cap" style="color: white; font-size: 1.25rem;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Integrasi Akademik</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">Gabungan sempurna latihan ketenteraan dengan pendidikan universiti</p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 50px; height: 50px; min-width: 50px; min-height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-users" style="color: white; font-size: 1.25rem;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Pembangunan Kepimpinan</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">Latihan kepimpinan komprehensif dan pengalaman praktikal</p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 50px; height: 50px; min-width: 50px; min-height: 50px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-anchor" style="color: white; font-size: 1.25rem;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="color: var(--text-primary); margin-bottom: 0.25rem;">Kecemerlangan Tentera Laut</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">Kemahiran maritim lanjutan dan latihan operasi tentera laut</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);" ></div>

    <!-- Cadet Timeline Section -->
    <section id="timeline" class="section">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Kecemerlangan Latihan</div>
                <h2 class="section-title">Garis Masa Perjalanan Kadet</h2>
                <p class="section-description">
                    Ikuti laluan komprehensif dari permohonan hingga pentauliahan, direka untuk mengubah pelajar yang berdedikasi menjadi pegawai tentera laut yang cemerlang melalui fasa latihan berstruktur.
                </p>
            </div>
            
            <div class="timeline">
                <!-- Timeline Icon 1 - Foundation Training -->
                <div class="timeline-center-icon" style="top: 15%;">
                    <button onclick="window.location.href='{{ route('about-me') }}'" style="background: none; border: none; cursor: pointer; font-size: 1.8rem; color: white;" title="About the Developer">
                        <i class="fas fa-anchor"></i>
                    </button>
                </div>
                
                <!-- Row 1: Junior Phase (left) + Video (right) -->
                <div class="timeline-row">
                    <div class="timeline-item timeline-left">
                        <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('storage/landing/2.jpeg'); background-size: cover; background-position: center;">
                            <div class="timeline-content-inner">
                                <h3 style="color: var(--primary-blue); margin-bottom: 1rem; text-align: center; font-weight: 700;">Fasa Junior</h3>
                                <p style="color: var(--text-secondary); text-align: center;">
                                    Pengenalan kepada disiplin ketenteraan, tradisi tentera laut, latihan asas, pelayaran, dan pemulihan fizikal. 
                                    Kadet membangunkan kerja berpasukan asas, daya tahan, dan komitmen.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item timeline-right">
                        <div class="timeline-video-content">
                            <video class="timeline-video" autoplay muted loop playsinline disablePictureInPicture>
                                <source src="storage/assets/videos/video-pengambilan.mp4" type="video/mp4">
                                <div class="video-fallback">
                                    <i class="fas fa-video" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                                    <p>Video Fasa Junior</p>
                                </div>
                            </video>
                        </div>
                    </div>
                </div>

                <!-- Timeline Icon 2 - Intermediate -->
                <div class="timeline-center-icon" style="top: 35%;">
                    <i class="fas fa-compass"></i>
                </div>

                <!-- Row 2: Video (left) + Intermediate Phase (right) -->
                <div class="timeline-row">
                    <div class="timeline-item timeline-left">
                        <div class="timeline-video-content">
                            <video class="timeline-video" autoplay muted loop playsinline disablePictureInPicture>
                                <source src="storage/assets/videos/video-fasa.mp4" type="video/mp4">
                                <div class="video-fallback">
                                    <i class="fas fa-video" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                                    <p>Video Fasa Pertengahan</p>
                                </div>
                            </video>
                        </div>
                    </div>
                    
                    <div class="timeline-item timeline-right">
                        <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('storage/landing/5.png'); background-size: cover; background-position: center;">
                            <div class="timeline-content-inner">
                                <h3 style="color: var(--primary-blue); margin-bottom: 1rem; text-align: center; font-weight: 700;">Fasa Intermediate</h3>
                                <p style="color: var(--text-secondary); text-align: center;">
                                    Fokus kepada pelayaran lanjutan, navigasi, operasi maritim, dan kepimpinan gunaan.
                                    Kadet memperoleh latihan praktikal, latihan lapangan, dan pendedahan kepada undang-undang tentera laut dan protokol keselamatan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Icon 3 - Senior -->
                <div class="timeline-center-icon" style="top: 55%;">
                    <i class="fas fa-star"></i>
                </div>

                <!-- Row 3: Senior Phase (left) + Video (right) -->
                <div class="timeline-row">
                    <div class="timeline-item timeline-left">
                        <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('storage/landing/11.png'); background-size: cover; background-position: center;">
                            <div class="timeline-content-inner">
                                <h3 style="color: var(--primary-blue); margin-bottom: 1rem; text-align: center; font-weight: 700;">Fasa Senior</h3>
                                <p style="color: var(--text-secondary); text-align: center;">
                                    Pembangunan kepimpinan dan persediaan untuk tanggungjawab ketua.
                                    Kadet membimbing junior, menguruskan pasukan, dan mengamalkan membuat keputusan dalam senario tentera laut yang kompleks.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item timeline-right">
                        <div class="timeline-video-content">
                            <video class="timeline-video" autoplay muted loop playsinline disablePictureInPicture>
                                <source src="storage/assets/videos/video-fomdex.mp4" type="video/mp4">
                                <div class="video-fallback">
                                    <i class="fas fa-video" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                                    <p>Video Fasa Senior</p>
                                </div>
                            </video>
                        </div>
                    </div>
                </div>

                <!-- Timeline Icon 4 - Commissioning -->
                <div class="timeline-center-icon" style="top: 75%;">
                    <i class="fas fa-graduation-cap"></i>
                </div>

                <!-- Row 4: Video (left) + Commissioning (right) -->
                <div class="timeline-row">
                    <div class="timeline-item timeline-left">
                        <div class="timeline-video-content">
                            <video class="timeline-video" autoplay muted loop playsinline disablePictureInPicture>
                                <source src="storage/assets/videos/video-tauliah.mp4" type="video/mp4">
                                <div class="video-fallback">
                                    <i class="fas fa-video" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                                    <p>Video Pentauliahan</p>
                                </div>
                            </video>
                        </div>
                    </div>
                    
                    <div class="timeline-item timeline-right">
                        <div class="timeline-content" style="background-image: linear-gradient(rgba(46, 49, 60, 0.95), rgba(46, 49, 60, 0.95)), url('storage/landing/9.jpeg'); background-size: cover; background-position: center;">
                            <div class="timeline-content-inner">
                                <h3 style="color: var(--primary-blue); margin-bottom: 1rem; text-align: center; font-weight: 700;">Pentauliahan</h3>
                                <p style="color: var(--text-secondary); text-align: center;">
                                    Peringkat akhir kekadetaan. Kadet menjalani penilaian komprehensif dan pentauliahan upacara
                                    sebagai Leftenan Muda dalam Pasukan Simpanan Sukarela Tentera Laut (PSSTLDM). Secara rasmi bersedia untuk berkhidmat dalam pertahanan tentera laut Malaysia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- About Section -->
    <section id="about" class="section" style="background: linear-gradient(135deg, rgba(16, 20, 28, 0.95), rgba(60, 146, 217, 0.1));">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Warisan Kami</div>
                <h2 class="section-title">Kecemerlangan Melalui Tradisi</h2>
                <p class="section-description" id="aboutDescription">
                    Dengan dekad kejayaan yang terbukti, PALAPES telah menetapkan dirinya sebagai institusi terkemuka untuk membangunkan pemimpin maritim yang berkhidmat dengan cemerlang dalam kapasiti ketenteraan dan awam, menegakkan standard tertinggi kehormatan, keberanian, dan komitmen.
                </p>
            </div>

            <div class="enhanced-card animate-on-scroll" style="text-align: center; margin-top: 4rem;">
                <img src="{{ asset('storage/assets/images/tauliah.jpg') }}" alt="Formasi Kadet PALAPES" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);">
                <h3 style="color: var(--primary-blue); font-size: 2rem; margin-bottom: 1.5rem;">Membina Pemimpin Masa Depan</h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.8; max-width: 800px; margin: 0 auto;">
                    Program komprehensif kami melampaui latihan ketenteraan tradisional, memupuk pemikiran kritis, kepimpinan beretika, dan kebolehsuaian yang diperlukan untuk cemerlang dalam persekitaran global yang sentiasa berubah. Graduan muncul sebagai pemimpin yang yakin dan berkebolehan siap untuk membuat sumbangan bermakna kepada masyarakat.
                </p>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- Benefits Section -->
    <section id="benefits" class="section">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Faedah Program</div>
                <h2 class="section-title">Sistem Sokongan Komprehensif</h2>
                <p class="section-description">
                    PALAPES menyediakan sokongan meluas untuk memastikan kejayaan kadet melalui bantuan kewangan, penginapan, pembekalan peralatan, dan peluang pembangunan kerjaya yang tiada tandingan.
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="feature-title">Elaun Bulanan</h3>
                    <p class="feature-description">Elaun bulanan sepanjang 3 tahun latihan untuk menyokong perbelanjaan sara hidup pelajar dan mengurangkan beban kewangan keluarga.</p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="feature-title">Sajian Latihan</h3>
                    <p class="feature-description">Makanan disediakan sepanjang tempoh latihan untuk memastikan keperluan asas kadet terpenuhi dengan sempurna.</p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="feature-title">Jaminan Kolej Kediaman</h3>
                    <p class="feature-description">Jaminan penginapan di Kolej Kediaman Tun Mustapha selama 3 tahun dengan kemudahan lengkap yang kondusif untuk pembelajaran dan latihan.</p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <h3 class="feature-title">Uniform & Aksesori</h3>
                    <p class="feature-description">Pembekalan lengkap uniform ketenteraan, kelengkapan tentera, dan semua peralatan yang diperlukan untuk latihan dan aktiviti rasmi.</p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="feature-title">Tambahan 6 Jam Kredit</h3>
                    <p class="feature-description">Tambahan 6 jam kredit untuk membantu dalam pengijazahan dan meningkatkan pencapaian akademik pelajar.</p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3 class="feature-title">Pentauliahan</h3>
                    <p class="feature-description">Ditauliahkan oleh Yang di-Pertuan Agong sebagai Leftenan Muda dalam pasukan tentera laut simpanan dengan pengiktirafan rasmi.</p>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- Requirements Section -->
    <section id="requirements" class="section" style="background: linear-gradient(135deg, rgba(16, 20, 28, 0.95), rgba(60, 146, 217, 0.1));">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Kriteria Kelayakan</div>
                <h2 class="section-title">Syarat Permohonan</h2>
                <p class="section-description">
                    Kami mencari individu yang luar biasa yang menunjukkan kecemerlangan akademik, kecergasan fizikal, peribadi bermoral, dan potensi untuk pembangunan kepimpinan ketenteraan yang cemerlang.
                </p>
            </div>

            <div class="requirements-grid">
                <div class="requirement-card animate-on-scroll">
                    <h3>Syarat Kelayakan Am</h3>
                    <ul>
                        <li>Warganegara Malaysia</li>
                        <li>Pelajar prasiswazah sepenuh masa UMS</li>
                        <li>Tempoh pengajian 3 tahun dan ke atas</li>
                        <li>Kepujian 3 subjek wajib SPM (BM, BI, Matematik)</li>
                        <li>Sihat tubuh badan dan mental</li>
                        <li>Tiada masalah flat foot dan scoliosis</li>
                        <li>Tidak rabun warna</li>
                        <li>Pendengaran yang baik</li>
                        <li>Tahap kecergasan fizikal yang baik</li>
                    </ul>
                </div>
                
                <div class="requirement-card animate-on-scroll">
                    <h3>Syarat Fizikal</h3>
                    <ul>
                        <li class="no-tick"><strong>Ketinggian minimum:</strong></li>
                        <li>Lelaki: 162 cm</li>
                        <li>Wanita: 157 cm</li>
                        <li class="no-tick"><strong>Berat badan minimum:</strong></li>
                        <li>Lelaki: 47.5 kg ke atas</li>
                        <li>Wanita: 45.0 kg ke atas</li>
                        <li>BMI: 18.00 - 26.00</li>
                        <li class="no-tick"><strong>Ukuran lilit dada (Lelaki):</strong></li>
                        <li>76 cm (sebelum tarik nafas), 81 cm (selepas tarik nafas)</li>
                    </ul>
                </div>
                
                <div class="requirement-card animate-on-scroll">
                    <h3>Ujian Fizikal</h3>
                    <ul>
                        <li>Larian 2.4km</li>
                        <li>Bangkit Tubi</li>
                        <li>Pull-up</li>
                        <li>Lompat jauh statik</li>
                        <li>Lari ulang alik 4x10m</li>
                    </ul>
                </div>
                
                <div class="requirement-card animate-on-scroll">
                    <h3>Dokumen Diperlukan</h3>
                    <ul>
                        <li>Kad pengenalan pelajar (3 salinan)</li>
                        <li>Kad pengenalan ibu bapa/waris (3 salinan)</li>
                        <li>Sijil kelahiran pelajar & ibu bapa/waris (3 salinan)</li>
                        <li>Surat berhenti sekolah (3 salinan)</li>
                        <li>Gambar berukuran passport (3 keping)</li>
                        <li>Slip keputusan akademik (3 salinan) *SPM/STPM/Matrikulasi/Diploma</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- Selection Process Section -->
    <section id="selection" class="section">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Proses Pemilihan</div>
                <h2 class="section-title">Laluan ke Penerimaan</h2>
                <p class="section-description">
                    Proses pemilihan komprehensif kami memastikan kami mengenal pasti calon dengan potensi tertinggi untuk kejayaan dalam kepimpinan ketenteraan dan kecemerlangan akademik.
                </p>
            </div>

            <div class="features-grid">
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">1</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Semakan Dokumen</h3>
                    <p style="color: var(--text-secondary);">Saringan awal dokumen permohonan, rekod akademik, dan pengesahan kelayakan oleh jawatankuasa pemilihan pakar kami.</p>
                </div>
                
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">2</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Ujian Kawad</h3>
                    <p style="color: var(--text-secondary);">Ujian kawad asas memberi penekanan kepada kemahiran kawad kaki asas termasuk pergerakan di tempat, perubahan arah, pergerakan maju ke hadapan, serta disiplin dalam barisan.</p>
                </div>
                
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">3</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Penilaian Fizikal</h3>
                    <p style="color: var(--text-secondary);">Penilaian kecergasan fizikal yang ketat termasuk ujian ketahanan, penilaian kekuatan, ujian kawad, dan halangan rintangan.</p>
                </div>
                
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">4</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Pemeriksaan Perubatan</h3>
                    <p style="color: var(--text-secondary);">Saringan perubatan komprehensif yang dijalankan oleh pegawai perubatan ketenteraan yang diperakui untuk memastikan kecergasan lengkap untuk perkhidmatan tentera laut.</p>
                </div>
                
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">5</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Temuduga Panel</h3>
                    <p style="color: var(--text-secondary);">Temuduga mendalam dengan pegawai kanan dan pengajar untuk menilai potensi kepimpinan, motivasi, peribadi, dan komitmen untuk berkhidmat.</p>
                </div>
                
                <div class="enhanced-card animate-on-scroll" style="position: relative;">
                    <div style="position: absolute; top: 15px; left: 30px; width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 3px solid var(--dark-navy);">6</div>
                    <h3 style="color: var(--primary-blue); margin: 2rem 0 1rem;">Pemilihan Akhir</h3>
                    <p style="color: var(--text-secondary);">Calon yang berjaya menerima surat tawaran rasmi dan memulakan perjalanan transformatif mereka sebagai kadet PALAPES.</p>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- Application Section -->
        <section id="application" class="section">
            <div class="section-container">
                <div class="section-header animate-on-scroll">
                    <div class="section-badge">Sertai PALAPES</div>
                    <h2 class="section-title">Mulakan Perjalanan Kepimpinan Anda</h2>
                    <p class="section-description">
                        Ambil langkah tegas pertama ke arah menjadi pegawai tentera laut yang ditauliahkan. Proses permohonan komprehensif kami memastikan kami memilih calon yang paling layak dan berdedikasi untuk program berprestij ini.
                    </p>
                </div>

                <div class="application-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-top: 4rem;">
                    <div class="enhanced-card animate-on-scroll">
                        <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.75rem;">Proses Permohonan</h3>
                        
                    <div style="margin-bottom: 2rem;">
                        <h4 style="color: var(--text-primary); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-file-alt" style="color: var(--primary-blue);"></i>
                            Langkah-langkah Permohonan
                        </h4>
                        <ol style="color: var(--text-secondary); font-size: 1rem; line-height: 1.8; padding-left: 1.5rem;">
                            <li style="margin-bottom: 0.75rem;">Sahkan anda memenuhi semua syarat program</li>
                            <li style="margin-bottom: 0.75rem;">Lengkapkan borang permohonan dalam talian</li>
                            <li style="margin-bottom: 0.75rem;">Sediakan semua dokumen diperlukan (3 salinan)</li>
                            <li style="margin-bottom: 0.75rem;">Hadiri ujian kecergasan asas</li>
                            <li style="margin-bottom: 0.75rem;">Hadiri temuduga dan penilaian</li>
                            <li style="margin-bottom: 0.75rem;">Mulakan perjalanan PALAPES anda!</li>
                        </ol>
                    </div>

                        <div style="margin-bottom: 2rem;">
                            <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.5rem;">Bersedia untuk berkhidmat kepada Malaysia?</p>
                            <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">Mohon hari ini untuk menyertai PALAPES Laut UMS dan kembangkan kemahiran kepimpinan, disiplin, dan peribadi yang akan membezakan anda seumur hidup.</p>
                        </div>

                        <div style="text-align: center;">
                            <a href="{{ route('application.create') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; font-size: 1.1rem;">
                                <i class="fas fa-paper-plane"></i>
                                Akses Portal Permohonan
                            </a>
                        </div>
                    </div>

                    <div class="enhanced-card animate-on-scroll" style="text-align: center;">
                        <h3 style="color: var(--primary-blue); margin-bottom: 2rem; font-size: 1.75rem;">Kod QR Akses Pantas</h3>
                        
                        <div class="qr-code-container">
                            @if(\App\Models\ContentSetting::get('qr_code_image'))
                                <img id="qrCodeImage" src="{{ asset(\App\Models\ContentSetting::get('qr_code_image')) }}" alt="Kod QR">
                            @else
                                <div style="color: #666; text-align: center; padding: 2rem;">
                                    <i class="fas fa-qrcode" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    <p style="margin: 0; font-size: 0.9rem;">Kod QR akan muncul di sini apabila dimuat naik oleh pengajar</p>
                                </div>
                            @endif
                        </div>
                        
                        <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.5rem; font-size: 1.1rem;">Imbas untuk Maklumat Lanjut</p>
                        <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 2rem;">Gunakan peranti mudah alih anda untuk mengimbas kod QR ini dan dapatkan update terkini mengenai proses permohonan anda</p>
                        
                        <div style="background: rgba(60, 146, 217, 0.1); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(60, 146, 217, 0.2);">
                            <h4 style="color: var(--primary-blue); margin-bottom: 0.5rem;">Perlukan Bantuan?</h4>
                            <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Hubungi pasukan kemasukan kami untuk sokongan permohonan dan pertanyaan program</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <div style="width: 80%; height: 3px; background: var(--gradient-accent); margin: 4rem auto; box-shadow: 0 2px 10px rgba(60, 146, 217, 0.3);"></div>

    <!-- Gallery Section -->
    <section id="gallery" class="section">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-badge">Galeri Kami</div>
                <h2 class="section-title">Lihat Perjalanan Kami</h2>
                <p class="section-description">
                    Terokai koleksi foto dan kenangan indah daripada latihan, aktiviti, dan pencapaian PALAPES Laut UMS.
                    Setiap gambar menceritakan kisah dedikasi, disiplin, dan semangat kekitaan.
                </p>
            </div>

            <div class="gallery-preview animate-on-scroll" style="margin-top: 4rem; text-align: center;">
                <div style="background: rgba(60, 146, 217, 0.05); padding: 4rem 2rem; border-radius: 16px; border: 2px solid rgba(60, 146, 217, 0.2);">
                    <i class="fas fa-images" style="font-size: 5rem; color: var(--primary-blue); margin-bottom: 2rem; opacity: 0.8;"></i>
                    <h3 style="color: var(--text-primary); font-size: 2rem; margin-bottom: 1.5rem;">Koleksi Foto Penuh</h3>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 600px; margin: 0 auto 2.5rem;">
                        Lawati galeri lengkap kami untuk melihat lebih banyak foto aktiviti latihan, pertandingan,
                        majlis rasmi, dan saat-saat bersejarah PALAPES Laut UMS.
                    </p>
                    <a href="{{ route('public.gallery') }}" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1.25rem 2.5rem; font-size: 1.1rem;">
                        <i class="fas fa-arrow-right"></i>
                        Lihat Galeri Penuh
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>PALAPES Laut UMS</h3>
                <p>Pasukan Latihan Pegawai Simpanan di Universiti Malaysia Sabah komited untuk membangunkan pemimpin maritim yang luar biasa melalui latihan komprehensif, kecemerlangan akademik, dan pembangunan peribadi.</p>
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
                <h3>Maklumat Hubungan</h3>
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem;">
                    <i class="fas fa-map-marker-alt" style="color: var(--primary-blue); margin-top: 0.25rem;"></i>
                    <div>
                        <p>Pejabat PALAPES, Blok B</p>
                        <p>Universiti Malaysia Sabah</p>
                        <p>Jalan UMS, 88400 Kota Kinabalu</p>
                        <p>Sabah, Malaysia</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <i class="fas fa-phone" style="color: var(--primary-blue);"></i>
                    <p>+60 12-3456789</p>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-envelope" style="color: var(--primary-blue);"></i>
                    <p>palapeslautums@ums.edu.my</p>
                </div>
            </div>

            <div class="footer-section">
                <h3>Cari Kami Di Sini</h3>
                <div style="width: 100%; height: 200px; background: rgba(60, 146, 217, 0.1); border-radius: 8px; border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; overflow: hidden;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d991.9088727330876!2d116.1296105786893!3d6.044647273346967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smy!4v1758376029404!5m2!1sen!2smy" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <i class="fas fa-map-marker-alt" style="color: var(--primary-blue); margin-top: 0.25rem;"></i>
                    <div>
                        <p style="margin-bottom: 0.25rem; font-weight: 600; color: var(--text-primary);">Lawati Markas Kami</p>
                        <p style="margin: 0; font-size: 0.9rem;">Blok B, Universiti Malaysia Sabah<br>Jalan UMS, 88400 Kota Kinabalu<br>Sabah, Malaysia</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 PALAPES Laut UMS - Pasukan Latihan Pegawai Simpanan, Universiti Malaysia Sabah. Hak cipta terpelihara.</p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--text-secondary);">
                Berkhidmat untuk Malaysia | Membina Peribadi | Sedia Berkorban
            </p>
        </div>
    </footer>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content" style="max-width: 420px;">
            <div class="modal-header">
                <h2>Confirm Logout</h2>
                <button class="close-btn" id="closeLogoutModal">&times;</button>
            </div>
            
            <div style="padding: 2rem; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(236, 108, 108, 0.1); border: 2px solid rgba(236, 108, 108, 0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-sign-out-alt" style="font-size: 1.5rem; color: var(--accent-pink);"></i>
                </div>
                
                <h3 style="color: var(--text-primary); margin: 0 0 1rem 0; font-size: 1.2rem; font-weight: 600;">
                    Are you sure you want to log out?
                </h3>
                
                <p style="color: var(--text-secondary); margin: 0; line-height: 1.5;">
                    You will be signed out and redirected to the login page.
                </p>
            </div>
            
            <div class="modal-buttons" style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <button type="button" class="btn-secondary-modal" id="cancelLogout">
                    Cancel
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #ec6c6c, #d64545); padding: 12px 24px; border: none; border-radius: 8px; color: white; cursor: pointer; transition: all 0.3s ease; font-size: 1rem; font-weight: 500;">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal for Instructors -->
    @auth
        @if(in_array(auth()->user()->role, ['instructor', 'admin']))
        <div id="editModal" class="modal">
            <div class="modal-content" style="max-width: 700px;">
                <div class="modal-header">
                    <h2>Edit Page Content</h2>
                    <button class="close-btn" id="closeModal">&times;</button>
                </div>
                
                <form id="editForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="applicationDeadline">Application Deadline Date:</label>
                        <input type="date" id="applicationDeadline" name="application_deadline" min="{{ date('Y-m-d') }}">
                        <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i>
                            Banner shows 2 months before deadline and disappears day after
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="whatsappGroupUrl">WhatsApp Group URL:</label>
                        <input type="url" id="whatsappGroupUrl" name="whatsapp_group_url" placeholder="https://chat.whatsapp.com/xxx">
                        <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                            <i class="fab fa-whatsapp"></i> 
                            WhatsApp group link shown on the application success page
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="qrCodeImageUpload">QR Code Image:</label>
                        <input type="file" id="qrCodeImageUpload" name="qr_code_image" accept="image/*" onchange="validateQRCodeImageSize(this)">
                        <small style="color: var(--text-secondary); display: block; margin-top: 0.5rem;">
                            <i class="fas fa-qrcode"></i>
                            Upload a QR code image (JPG, PNG, SVG - max 2MB)
                        </small>
                        <small id="qr-code-error" style="color: #ef5350; display: none; margin-top: 0.5rem;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span id="qr-code-error-text"></span>
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="heroTitle">Hero Section Title:</label>
                        <input type="text" id="heroTitle" name="hero_title" maxlength="255" placeholder="Excellence in Maritime Leadership">
                    </div>
                    
                    <div class="form-group">
                        <label for="heroSubtitle">Hero Section Subtitle:</label>
                        <textarea id="heroSubtitle" name="hero_subtitle" rows="3" maxlength="1000" placeholder="Forge your path as a naval officer..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="introDescription">Introduction Description:</label>
                        <textarea id="introDescription" name="intro_description" rows="4" maxlength="2000" placeholder="The Reserve Officer Training Unit (PALAPES)..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="aboutDescription">About Section Description:</label>
                        <textarea id="aboutDescription" name="about_description" rows="4" maxlength="2000" placeholder="With decades of proven success..."></textarea>
                    </div>
                    
                    <div class="modal-buttons">
                        <button type="button" class="btn-secondary-modal" id="cancelEdit">Cancel</button>
                        <button type="button" class="btn-secondary-modal" id="resetToDefaults">
                            <i class="fas fa-undo"></i> Reset to Defaults
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @endauth

<script>
        // Enhanced JavaScript with Backend Integration
        
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

        // Auto-advance carousel every 6 seconds
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

        // Enhanced navbar scroll effects with hide/show functionality
        let lastScrollY = window.scrollY;
        const navbar = document.getElementById('navbar');
        const notificationBanner = document.getElementById('notificationBanner');

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > 100) {
                navbar.classList.add('scrolled');
                if (currentScrollY > lastScrollY && currentScrollY > 200) {
                    navbar.style.transform = 'translateY(-100%)';
                    // Move notification banner to top when navbar is hidden
                    if (notificationBanner && !notificationBanner.classList.contains('hidden')) {
                        notificationBanner.style.top = '0';
                    }
                } else {
                    navbar.style.transform = 'translateY(0)';
                    // Move notification banner back to below navbar
                    if (notificationBanner && !notificationBanner.classList.contains('hidden')) {
                        notificationBanner.style.top = '81px';
                    }
                }
            } else {
                navbar.classList.remove('scrolled');
                navbar.style.transform = 'translateY(0)';
                // Ensure notification banner is in correct position
                if (notificationBanner && !notificationBanner.classList.contains('hidden')) {
                    notificationBanner.style.top = '81px';
                }
            }

            lastScrollY = currentScrollY;
        });

        // Mobile menu toggle with animation
        const mobileToggle = document.getElementById('mobileToggle');
        const navLinks = document.getElementById('navLinks');
        const navOverlay = document.getElementById('navOverlay');

        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
            navOverlay.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
        });

        // Close mobile menu when clicking overlay
        navOverlay.addEventListener('click', function() {
            mobileToggle.classList.remove('active');
            navLinks.classList.remove('active');
            navOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // User Dropdown Functionality
        const userDropdown = document.querySelector('.user-dropdown');
        const userDropdownTrigger = document.getElementById('userDropdownTrigger');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        const editPageBtn = document.getElementById('editPageBtn');
        const mobileEditPageBtn = document.getElementById('mobileEditPageBtn');
        const dropdownLogoutBtn = document.getElementById('dropdownLogoutBtn');
        const mobileLogoutBtn = document.getElementById('mobileLogoutBtn');

        // Toggle dropdown
        userDropdownTrigger?.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown?.contains(e.target)) {
                userDropdown?.classList.remove('active');
            }
        });

        // Edit page button handlers
        editPageBtn?.addEventListener('click', function() {
            userDropdown.classList.remove('active');
            // Trigger existing edit modal
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                loadCurrentSettings();
            }
        });

        mobileEditPageBtn?.addEventListener('click', function() {
            // Close mobile menu
            navLinks.classList.remove('active');
            mobileToggle.classList.remove('active');
            navOverlay.classList.remove('active');
            document.body.style.overflow = '';
            // Trigger existing edit modal
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                loadCurrentSettings();
            }
        });

        // Logout button handlers - Connect to logout modal
        dropdownLogoutBtn?.addEventListener('click', function() {
            userDropdown.classList.remove('active');
            // Show logout confirmation modal
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal) {
                logoutModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });

        mobileLogoutBtn?.addEventListener('click', function() {
            // Close mobile menu
            navLinks.classList.remove('active');
            mobileToggle.classList.remove('active');
            navOverlay.classList.remove('active');
            document.body.style.overflow = '';
            // Show logout confirmation modal
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal) {
                logoutModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });

        // Close dropdown when mobile menu is opened
        mobileToggle?.addEventListener('click', function() {
            userDropdown?.classList.remove('active');
        });

        // Logout modal functionality
        const logoutModal = document.getElementById('logoutModal');
        const closeLogoutModal = document.getElementById('closeLogoutModal');
        const cancelLogout = document.getElementById('cancelLogout');

        // Close logout modal function
        function closeLogoutModalFunc() {
            if (logoutModal) {
                logoutModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal event listeners
        closeLogoutModal?.addEventListener('click', closeLogoutModalFunc);
        cancelLogout?.addEventListener('click', closeLogoutModalFunc);

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === logoutModal) {
                closeLogoutModalFunc();
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
                    navOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                    // Close user dropdown if open
                    userDropdown?.classList.remove('active');
                }
            });
        });

        // Intersection observer for scroll animations
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

        // Timeline animation with staggered effect
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

        // Content Management Modal functionality (for instructors/admins)
        const modal = document.getElementById('editModal');
        const editBtn = document.getElementById('editBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelEdit = document.getElementById('cancelEdit');
        const editForm = document.getElementById('editForm');
        const resetBtn = document.getElementById('resetToDefaults');

        // Load current content settings from backend
        function loadCurrentSettings() {
            fetch('/api/content-settings')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const settings = data.data;
                        
                        // Populate form fields with current values
                        if (settings.application_deadline) {
                            document.getElementById('applicationDeadline').value = settings.application_deadline;
                        }
                        if (settings.whatsapp_group_url) {
                            document.getElementById('whatsappGroupUrl').value = settings.whatsapp_group_url;
                        }
                        if (settings.hero_title) {
                            document.getElementById('heroTitle').value = settings.hero_title;
                        }
                        if (settings.hero_subtitle) {
                            document.getElementById('heroSubtitle').value = settings.hero_subtitle;
                        }
                        if (settings.intro_description) {
                            document.getElementById('introDescription').value = settings.intro_description;
                        }
                        if (settings.about_description) {
                            document.getElementById('aboutDescription').value = settings.about_description;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading settings:', error);
                    showMessage('Error loading current settings', 'error');
                });
        }

        // Open modal with current settings
        editBtn?.addEventListener('click', function() {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            loadCurrentSettings();
        });

        // Close modal function
        function closeEditModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Modal close event listeners
        closeModal?.addEventListener('click', closeEditModal);
        cancelEdit?.addEventListener('click', closeEditModal);

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeEditModal();
            }
        });

        // Form submission with AJAX
        editForm?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(editForm);
            
            // Show loading state
            const submitBtn = editForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;
            
            // Submit to backend
            fetch('/content-management/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update page content immediately without reload
                    updatePageContent(data.data);
                    showMessage('Content updated successfully!', 'success');
                    closeEditModal();
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        Object.values(data.errors).forEach(errors => {
                            errors.forEach(error => {
                                errorMessage += '• ' + error + '\n';
                            });
                        });
                        showMessage(errorMessage, 'error');
                    } else {
                        showMessage(data.message || 'An error occurred', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred while saving changes', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Reset to defaults functionality
        resetBtn?.addEventListener('click', function() {
            if (confirm('Are you sure you want to reset all content to defaults? This action cannot be undone.')) {
                const resetButton = this;
                const originalText = resetButton.innerHTML;
                resetButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resetting...';
                resetButton.disabled = true;
                
                fetch('/content-management/reset', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('Content reset to defaults successfully!', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showMessage(data.message || 'Error resetting content', 'error');
                        resetButton.innerHTML = originalText;
                        resetButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error resetting content:', error);
                    showMessage('Error resetting content', 'error');
                    resetButton.innerHTML = originalText;
                    resetButton.disabled = false;
                });
            }
        });

        // Update page content dynamically after successful save
        function updatePageContent(data) {
            // Update notification banner visibility and text
            const notificationBanner = document.getElementById('notificationBanner');
            if (data.show_banner && data.formatted_deadline) {
                if (notificationBanner) {
                    notificationBanner.style.display = 'block';
                    const notificationText = document.getElementById('notificationText');
                    if (notificationText) {
                        notificationText.textContent = 
                            `Applications for the upcoming semester are now open. Deadline: ${data.formatted_deadline}`;
                    }
                }
            } else if (notificationBanner) {
                notificationBanner.style.display = 'none';
            }
            
            // Update QR code image
            if (data.qr_code_url) {
                const qrImage = document.getElementById('qrCodeImage');
                if (qrImage) {
                    qrImage.src = data.qr_code_url;
                }
            }
            
            // Update dynamic text content on the page
            const heroTitle = document.getElementById('heroTitle');
            const heroSubtitle = document.getElementById('heroSubtitle');
            const introDesc = document.getElementById('introDescription');
            const aboutDesc = document.getElementById('aboutDescription');
            
            if (data.hero_title && heroTitle) {
                heroTitle.textContent = data.hero_title;
            }
            if (data.hero_subtitle && heroSubtitle) {
                heroSubtitle.textContent = data.hero_subtitle;
            }
            if (data.intro_description && introDesc) {
                introDesc.textContent = data.intro_description;
            }
            if (data.about_description && aboutDesc) {
                aboutDesc.textContent = data.about_description;
            }
        }

        // Enhanced message display system
        function showMessage(message, type = 'success') {
            const messageDiv = document.createElement('div');
            const bgColor = type === 'success' ? 'var(--gradient-primary)' : 'linear-gradient(135deg, #e74c3c, #c0392b)';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            messageDiv.innerHTML = `
                <div style="position: fixed; top: 100px; right: 20px; background: ${bgColor}; color: white; padding: 1rem 2rem; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); z-index: 3001; animation: slideInRight 0.3s ease; max-width: 400px; word-wrap: break-word;">
                    <i class="fas ${icon}" style="margin-right: 0.5rem;"></i>${message.replace(/\n/g, '<br>')}
                </div>
            `;
            
            document.body.appendChild(messageDiv);
            
            // Auto-remove message
            const duration = type === 'error' ? 5000 : 3000;
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, duration);
        }

        // Hide notification banner function
        function hideNotification() {
            const banner = document.getElementById('notificationBanner');
            if (banner) {
                banner.classList.add('hidden');
                setTimeout(() => {
                    if (banner.parentNode) {
                        banner.style.display = 'none';
                    }
                }, 300);
            }
        }

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

        // Update active navigation on scroll
        window.addEventListener('scroll', updateActiveNavLink);

        // Initialize page animations
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

            // Ensure logout button styling
            const logoutButton = document.getElementById('logoutBtn');
            if (logoutButton) {
                logoutButton.style.border = 'none';
                logoutButton.style.outline = 'none';
                logoutButton.style.fontSize = '0.95rem';
                logoutButton.style.fontWeight = '600';
            }
        });

        // Force timeline visibility - add this to your existing script section
        document.addEventListener('DOMContentLoaded', function() {
            // Force all timeline items to be visible immediately
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach(item => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
                item.style.visibility = 'visible';
                item.style.display = 'block';
                item.classList.add('visible');
            });
            
            // Force all timeline content to be visible
            const timelineContent = document.querySelectorAll('.timeline-content, .timeline-video-content');
            timelineContent.forEach(content => {
                content.style.opacity = '1';
                content.style.visibility = 'visible';
                content.style.display = 'flex';
            });
            
            // Force all videos to be visible
            const videos = document.querySelectorAll('.timeline-video');
            videos.forEach(video => {
                video.style.opacity = '1';
                video.style.visibility = 'visible';
                video.style.display = 'block';
            });
        });

        // File Size Validation for QR Code Image
        function validateQRCodeImageSize(input) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const errorElement = document.getElementById('qr-code-error');
            const errorText = document.getElementById('qr-code-error-text');
            const submitButton = input.closest('form').querySelector('button[type="submit"]');

            if (input.files && input.files[0]) {
                const fileSize = input.files[0].size;
                const fileName = input.files[0].name;

                if (fileSize > maxSize) {
                    const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
                    errorText.textContent = `File size (${fileSizeMB}MB) exceeds the maximum limit of 2MB. Please choose a smaller image.`;
                    errorElement.style.display = 'block';
                    input.value = ''; // Clear the file input

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.style.opacity = '0.5';
                        submitButton.style.cursor = 'not-allowed';
                    }

                    return false;
                } else {
                    errorElement.style.display = 'none';
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.style.opacity = '1';
                        submitButton.style.cursor = 'pointer';
                    }
                    return true;
                }
            }
            return true;
        }
    </script>
</body>
</html>