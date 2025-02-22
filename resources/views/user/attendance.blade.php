@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="pagetitle animate__animated  animate__fadeInDown  animate__delay-1s mt-4">
            <h3>Attendance</h3>
            <p>Review attendance records</p>
         </div>

        <div class="row">

            <div class="col-xxl-6 col-md-6">
                <div class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s border shadow-sm shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Time In <span>| Daily</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-md-6">
                <div class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s border shadow-sm shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Time Out <span>| Daily</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card animate__animated  animate__fadeIn  animate__delay-1s border shadow-sm shadow">
                    <div class="card-header">
                        <div class="w-50">
                            <form method="GET" action="{{ route('attendance') }}" class="w-70">
                                <div class="row g-2">
                                    <div class="col-lg-7 col-md-12">
                                        <input name="search" type="text" class="form-control" placeholder="Search" value="{{ request('search') }}">
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <select name="division" class="form-select">
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>
                                                    {{ $division }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-1 col-md-12 d-flex align-items-center">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                    <div class="card-body">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Time Record</th>
                                    <th scope="col">Date Record</th>
                                    <th scope="col">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance as $record)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $record->participant->name }}</td>
                                        <td>{{ $record->participant->division }}</td>
                                        <td>{{ $record->time_recorded }}</td>
                                        <td>{{ $record->created_at->format('F j, Y') }}</td>
                                        <td>{{ $record->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="mx-3">
                        {{ $attendance->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection