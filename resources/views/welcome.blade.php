@extends('layouts.app')

@section('title', 'Welcome')
@section('content')


    <section class="d-flex align-items-center vh-100">
        <div class="filter"></div>
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Left Side: Carousel -->
                <div
                    class="col-lg-6  d-flex flex-column justify-content-center align-items-center p-0 position-relative  animate__animated  animate__fadeIn  animate__delay-1s">

                    <div class="carousel-login w-100 h-100 position-relative">
                        <!-- Overlay with Opacity -->
                        <div class="carousel-overlay"></div>

                        <div class="carousel-slide" style="background-image: url({{ asset('image/hero-1.jpg') }});"></div>
                        <div class="carousel-slide" style="background-image: url({{ asset('image/hero-2.jpg') }});"></div>
                        <div class="carousel-slide" style="background-image: url({{ asset('image/hero-3.jpg') }});"></div>



                        <div class="carousel-quote text-white text-center px-4 ">
                            <h2 class="fw-bold text-white">SRAA South Cotabato</h2>
                            <p class="mt-2 text-white">
                                The SOCCSKSARGEN Regional Athletic Association (SRAA) Meet is a prestigious sports event
                                where young athletes from South Cotabato compete in various disciplines, showcasing their
                                skills and sportsmanship.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="col-lg-6 d-flex justify-content-center align-items-center    animate__animated  animate__fadeIn  animate__delay-1s">
                    <div class="login-form bg-white rounded w-100" style="max-width: 400px;">
                        <div class="text-center mb-2">
                            <img src="{{ asset('image/logo.png') }}" alt="Logo" class="img-fluid "
                                style="max-width: 170px;">
                        </div>
                        <form id="login-form" class="text-start" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div id="login-alert" class="alert d-none"></div>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <a>{{ $error }}</a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mb-2">
                                <label for="username" class="form-label text-black">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter your username" required>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label text-black">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" required>
                            </div>

                            <div class="text-end mb-2">
                                {{-- <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a> --}}
                                <a class="text-decoration-none">Forgot password?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" id="login-btn" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
