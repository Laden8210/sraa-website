<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>


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


    <script src="https://kit.fontawesome.com/8d62d56333.js" crossorigin="anonymous"></script>
    @vite(['resources/css/style.css', 'resources/js/main.js'])

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>@yield('title', 'Your App Name')</title>
</head>

<body>

    <div id="preloader">
        <div class="loader-container">
            <img src="{{ asset('image/logo.png') }}" alt="Lakbay Philippine Logo" class="loader-logo">
            <p class="loader-text">SRAA South Cotabato</p>
        </div>
    </div>

    <header id="header" class="fixed-top animate__animated  animate__fadeInDown shadow">
        <div class="container d-flex align-items-center justify-content-between px-4">
            <div>
                <a href="/" class="d-flex align-items-center">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" style="height: 32px;">

                </a>
            </div>


            <nav class="d-none d-md-flex">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('dashboard') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                            href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('qr-code') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                            href="{{ route('qr-code') }}">Help Center</a>
                    </li>
                    <li class="nav-item border-r-1">
                        <a class="nav-link {{ Request::routeIs('users') ? 'active fw-semibold border-bottom border-2 border-dark' : '' }}"
                            href="{{ route('users') }}">About</a>
                    </li>
                </ul>
            </nav>


            <div class="d-flex align-items-center">
                <a href="" class="btn btn-primary rounded-pill ">Login Now</a>
            </div>

        </div>
    </header>


    <main>

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>
