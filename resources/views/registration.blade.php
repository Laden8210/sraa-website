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
                        <form id="login-form" class="text-start" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div id="login-alert" class="alert d-none"></div>

                            @if ($errors->any())

                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        <a>{{ $error }}</a>
                                    </div>
                                @endforeach

                            @endif

                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <span class="text-danger" id="nameError"></span>
                                </div>
                                <div class="col-lg-12">
                                    <label for="division" class="form-label">Division</label>
                                    <select class="form-select form-control" id="division" name="division" required>
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division }}">{{ $division }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="divisionError"></span>
                                </div>
                                <div class="col-lg-12">
                                    <label for="school" class="form-label">School</label>
                                    <input type="text" class="form-control" id="school" name="school" required>
                                    <span class="text-danger" id="schoolError"></span>
                                </div>
                                <div class="col-lg-12">
                                    <label for="event" class="form-label">Event</label>
                                    <select class="form-select form-control" id="event" name="event" required>
                                        <option value="">Select Event</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event }}">{{ $event }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="eventError"></span>
                                </div>

                                <div class="col-lg-12">
                                    <label for="event" class="form-label">Role</label>
                                    <select class="form-select form-control" id="participant_role" name="participant_role" required>
                                        <option value="">Select Role</option>
                                        <option value="student">Student</option>
                                        <option value="coach">Coach</option>
                                        <option value="technical official">Technical Official</option>
                                        <option value="twd">TWD</option>
                                        <option value="management">Top Management</option>
                                    </select>
                                    <span class="text-danger" id="eventError"></span>
                                </div>
                    
                                <div class="col-lg-12">
                                    <label for="mobile_num" class="form-label">Contact #</label>
                                    <input type="text" class="form-control" id="mobile_num" name="mobile_num" required>
                                    <span class="text-danger" id="mobileNumError"></span>
                                </div>
                                <div class="col-lg-12 password-fields">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <span class="text-danger" id="passwordError"></span>
                                </div>
                                <div class="col-lg-12 password-fields">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                    <span class="text-danger" id="passwordConfirmationError"></span>
                                </div>
                            </div>

                            <div class="d-grid mt-3 mb-5">
                                <button type="submit" id="login-btn" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
