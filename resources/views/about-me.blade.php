<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About the Developer - ROTU NAVY UMS</title>
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
            background-color: var(--dark-navy);
            color: var(--text-primary);
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--accent-pink);
        }

        .about-section {
            text-align: center;
            margin-bottom: 4rem;
        }

        .about-section h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--text-primary), var(--primary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-section p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto;
        }

        .bio-card {
            background: rgba(60, 146, 217, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 3rem;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
            transition: all 0.4s ease;
        }

        .bio-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-blue);
            box-shadow: 0 20px 50px rgba(60, 146, 217, 0.2);
        }

        .bio-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            align-items: center;
        }

        .bio-image {
            text-align: center;
        }

        .bio-image img {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-blue);
            box-shadow: var(--shadow-primary);
        }

        .bio-text h2 {
            color: var(--primary-blue);
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .bio-text p {
            margin-bottom: 1rem;
            color: var(--text-secondary);
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .skill-item {
            background: rgba(60, 146, 217, 0.1);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .skill-item:hover {
            background: rgba(60, 146, 217, 0.2);
            border-color: var(--primary-blue);
        }

        .footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .bio-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .about-section h1 {
                font-size: 2rem;
            }

            .bio-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('landing') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <section class="about-section">
            <h1>About the Developer</h1>
            <p>Meet the mind behind ROTU NAVY UMS Cadet Management System & Learning Hub - a passionate developer dedicated to building innovative solutions for naval education and training.</p>
        </section>

        <div class="bio-card">
            <div class="bio-content">
                <div class="bio-image">
                    <img src="{{ asset('storage/assets/images/dev.png') }}" alt="Developer Photo" onerror="this.src='{{ asset('images/default.png') }}';">
                </div>
                <div class="bio-text">
                    <h2>Lt. M Hanif bin Nokman PSSTLDM</h2>
                    <p><strong>Software Engineering Student & Naval Technology Enthusiast</strong></p>
                    <p>With a background in software engineering and a deep appreciation for maritime excellence, I developed this platform to streamline the Reserve Officer Training Unit's operations at Universiti Malaysia Sabah.</p>
                    <p>This system combines modern web technologies with the discipline and precision required for naval training, ensuring cadets receive the best possible preparation for their service.</p>

                    <div class="skills-grid">
                        <div class="skill-item">
                            <i class="fas fa-code"></i>
                            <strong>Laravel & PHP</strong>
                        </div>
                        <div class="skill-item">
                            <i class="fab fa-js"></i>
                            <strong>JavaScript</strong>
                        </div>
                        <div class="skill-item">
                            <i class="fas fa-database"></i>
                            <strong>Database Design</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 ROTU NAVY UMS. Built with passion for maritime excellence.</p>
    </footer>
</body>
</html>
