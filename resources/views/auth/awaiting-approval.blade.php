<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Awaiting Approval</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body style="background-color: #1a1a1a;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/navy-logo.png') }}" alt="Logo" height="40">
            </a>
        </div>
    </nav>
    <section class="d-flex align-items-center justify-content-center" style="min-height: 80vh; background-color: #1a1a1a;">
        <div class="container text-center text-white">
            <h1 class="mb-4">Registration Submitted</h1>
            <p class="lead mb-5">Thank you for registering! Your account is pending approval by an administrator.<br>Please wait until your account is accepted.</p>
            <a href="{{ route('logout.and.landing') }}" class="btn btn-warning btn-lg">Back to Landing Page</a>
        </div>
    </section>

    <footer class="text-center text-white bg-dark py-3 fixed-bottom">
        &copy; {{ date('Y') }} PALAPES Laut UMS | Cadet Management & Learning Hub
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
