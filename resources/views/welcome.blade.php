<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadet Management & Learning Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Custom CSS -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <!-- Right side: Logo -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/navy-logo.png') }}" alt="Logo" height="40">
        </a>

        <!-- Toggle for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLinks" aria-controls="navbarLinks" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Left side: Navigation -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarLinks">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#introduction">Introduction</a></li>
                <li class="nav-item"><a class="nav-link" href="#benefits">Benefits</a></li>
                <li class="nav-item"><a class="nav-link" href="#requirements">Requirements</a></li>
                <li class="nav-item"><a class="nav-link" href="#join">Join Us</a></li>

                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Sections -->

<!-- Hero -->
<section class="hero-section text-center text-white d-flex align-items-center" style="min-height: 80vh; background-color: #1a1a1a;">
    <div class="container">
        <h1>Cadet Management & Learning Hub</h1>
        <p class="lead">PALAPES Laut UMS | RESERVE OFFICER TRAINING UNIT</p>
        <a href="#join" class="btn btn-warning mt-3">Get Started</a>
    </div>
</section>

<!-- Introduction -->
<section id="introduction" class="container py-5">
    <h2>Introduction</h2>
    <p>
        The Reserve Officer Training Unit (PALAPES) Laut UMS is a structured military training program designed to develop leadership, discipline, and maritime skills among university students.
    </p>
</section>

<!-- Benefits -->
<section id="benefits" class="container py-5">
    <h2>Benefits</h2>
    <ul class="list-group">
        <li class="list-group-item">Monthly Allowance</li>
        <li class="list-group-item">Issued Uniform & Gear</li>
        <li class="list-group-item">Guaranteed Campus Accommodation</li>
        <li class="list-group-item">Firearms & Naval Training</li>
        <li class="list-group-item">Leadership Development</li>
    </ul>
</section>

<!-- Requirements -->
<section id="requirements" class="container py-5">
    <h2>Requirements</h2>
    <ul class="list-group">
        <li class="list-group-item">Malaysian Citizen</li>
        <li class="list-group-item">Full-time university student</li>
        <li class="list-group-item">Physically and mentally fit</li>
        <li class="list-group-item">Able to commit to training</li>
    </ul>
</section>

<!-- Join Us -->
<section id="join" class="container py-5">
    <h2>Join Us</h2>
    <p>Ready to start your naval journey? <a href="{{ route('register') }}">Register here</a> to apply as a cadet or instructor.</p>
</section>

<!-- Footer -->
<footer class="text-center text-white bg-dark py-3">
    &copy; {{ date('Y') }} PALAPES Laut UMS | Cadet Management & Learning Hub
</footer>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
