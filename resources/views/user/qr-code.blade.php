@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="pagetitle animate__animated animate__fadeInDown animate__delay-1s mt-4">
                    <h3>Qr Codes</h3>
                    <p>| Generate, Print, and Download Qr Codes </p>
                </div>
                <div class="align-self-end">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <form method="POST" action="{{ route('generate-qr-id') }}">
                            @csrf
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="division" value="{{ request('division') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <button type="submit" class="btn btn-primary w-auto mb-3"><i class="fas fa-id-card me-1"
                                    aria-hidden="true"></i>Generate Qr IDs</button>
                        </form>
                        <form method="POST" action="{{ route('generate-qr-code') }}">
                            @csrf
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="division" value="{{ request('division') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <button type="submit" class="btn btn-primary w-auto mb-3"><i class="fas fa-qrcode me-1"
                                    aria-hidden="true"></i>Generate Qr Codes</button>
                        </form>

                    </div>

                </div>
            </div>
            <div class="card px-3 animate__animated animate__fadeIn animate__delay-1s mb-4 border shadow-sm shadow">
                <div class="w-75 mt-3  animate__animated  animate__fadeIn  animate__delay-1s">
                    <form method="GET" action="{{ route('qr-code') }}" class="mb-3 w-70">
                        <div class="row g-2">
                            <div class="col-lg-3 col-md-12">
                                <input name="search" type="text" class="form-control" placeholder="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <select name="event" class="form-select">
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}"
                                            {{ request('event') == $event ? 'selected' : '' }}>
                                            {{ $event }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (Auth::user()->role == 'admin')
                                

                                <div class="col-lg-3 col-md-12">
                                    <select name="division" class="form-select">
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division }}"
                                                {{ request('division') == $division ? 'selected' : '' }}>
                                                {{ $division }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            @endif
                            
                            <div class="col-lg-2 col-md-12">
                                <select name="role" class="form-select">
                                    <option value="">Select Role</option>
                                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student
                                    </option>
                                    <option value="coach" {{ request('role') == 'coach' ? 'selected' : '' }}>Coach
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-12 d-flex align-items-center gap-2">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button> 
                                <a href="{{ route('qr-code') }}" class="btn btn-secondary">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <div class="row">
            @if ($results->isEmpty())
                <div class="col-12 animate__animated animate__fadeIn animate__delay-1s">
                    <div class="text-center border-top pt-3" role="alert">
                        No records found.
                    </div>
                </div>
            @else
                @foreach ($results as $result)
                    <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                        <div class="card info-card student-card w-100 border shadow-sm shadow">
                            <div class="card-body d-flex align-items-center justify-content-between p-3 rounded-lg">

                                <!-- QR Code -->
                                <div class="d-flex align-items-center">
                                    {!! QrCode::size(150)->generate($result->qr_data) !!}
                                </div>


                                <!-- Student Info & Buttons -->
                                <div class="flex-grow-1">
                                    <div class="row mx-2 w-100">
                                        <div class="col-lg-12 col-md-12">
                                            <span class="fw-bold">{{ $result->name }} <span class="text-muted"
                                                    style="font-size: 12px;"> |
                                                    {{ $result->participant_role }}</span></span>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <span class="text-muted" style="font-size: 14px">{{ $result->division }}</span>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <span class="text-muted" style="font-size: 14px">{{ $result->school }}</span>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <span class="text-muted" style="font-size: 14px">{{ $result->event }}</span>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mt-1">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-secondary w-50"><i class="fa fa-qrcode"
                                                        aria-hidden="true"></i></button>
                                                <button class="btn btn-primary w-50"><i class="fa fa-id-card"
                                                        aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            @endif


        </div>
        <div class="mx-3">
            {{ $results->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
        </div>
    </section>



@endsection
