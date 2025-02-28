<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@600&family=Lobster&family=Pacifico&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="src/images/logo-with-bg.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://kit.fontawesome.com/8d62d56333.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.js"
        integrity="sha512-QgLS4OmTNBq9TujITTSh0jrZxZ55CFjs4wjK8NXsBoZb04UYl8wWQJNaS8jRiLq6/c60bEfOj3cPsxadHICNfw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @vite(['resources/css/style.css', 'resources/js/main.js'])


    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>@yield('title', 'Your App Name')</title>

</head>

<body class="bg-light">

    <div id="preloader">
        <div class="loader-container">
            <img src="{{ asset('image/logo.png') }}" alt="Lakbay Philippine Logo" class="loader-logo">
            <p class="loader-text">SRAA 2025</p>
        </div>
    </div>


    <header id="header" class="fixed-top animate__animated  animate__fadeInDown shadow-sm">
        <div class="container-fluid d-flex align-items-center justify-content-between my-0" style="padding-inline: 2%;">
            <div>
                <a class="navbar-brand d-flex align-items-center fw-bold fs-5" href="index.html">
                    <img class="m-2" src="{{ asset('image/logo.png') }}" alt="Logo" style="height: 50px;">
                    <div class="text-warning" style="color: #8e53fd !important">SRAA</div>
                    <div class="text-secondary">MEET</div>
                 </a>
            </div>


            <nav class="d-none d-md-flex">
                @if (Auth::user()->role == 'admin')
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dashboard') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('qr-code') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('qr-code') }}">QR Code</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('users') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('users') }}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('faculty') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('faculty') }}">Coaches</a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link {{ Request::routeIs('student') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('student') }}">Students</a>
                        </li>
                        <li class="nav-item position-relative">
                            <a class="nav-link {{ Request::routeIs('attendance') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('attendance') }}">Attendance</a>
                        </li>
                    </ul>
                @else
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dashboard') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('qr-code') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('qr-code') }}">QR Code</a>
                        </li>

                        <li class="nav-item position-relative">
                            <a class="nav-link {{ Request::routeIs('attendance') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                                href="{{ route('attendance') }}">Attendance</a>
                        </li>
                    </ul>
                @endif

            </nav>
            {{-- <nav class="navbar">
                <li class="active"><i class="fa-solid fa-house"></i>Home</li>
                <li><i class="fa-solid fa-circle-info"></i>About</li>
                <li><i class="fa-solid fa-rss"></i>Blog</li>
                <li><i class="fa-solid fa-gear"></i>Services</li>
                <li><i class="fa-solid fa-address-book"></i>Contact</li>
            </nav>
            <script src="https://kit.fontawesome.com/a692e1c39f.js" crossorigin="anonymous"></script> --}}

            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <a href="#" id="settingDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </a>
                    <ul class="dropdown-menu p-2 shadow mt-2">
                        <li><a href="logout" class="dropdown-item text-dark">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>



    <main style="padding-top: 80px" class="bg-light">

        @yield('content')

    </main>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



</body>

</html>
