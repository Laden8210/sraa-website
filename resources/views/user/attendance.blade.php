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
                <div
                    class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s border shadow-sm shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Time In <span>| Daily</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6 col-md-6">
                <div
                    class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s border shadow-sm shadow">
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
                        <div class="w-75">
                            <form method="GET" action="{{ route('attendance') }}" class="w-70">
                                <div class="row g-2">
                                    <div class="col-lg-3 col-md-12">
                                        <input name="search" type="text" class="form-control" placeholder="Search"
                                            value="{{ request('search') }}">
                                    </div>
                                    @if (Auth::user()->role == 'admin')
                                        <div class="col-lg-2 col-md-12">
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
                                            <option value="student" {{ request('role') == "student" ? 'selected' : '' }}>Student</option>
                                            <option value="coach" {{ request('role') == "coach" ? 'selected' : '' }}>Coach</option>
                                        </select>
                                    </div>
                                  
                                    <div class="col-lg-3 col-md-12">
                                        <input name="date" type="text" class="form-control" placeholder="Search"
                                            value="{{ request('date') }}" readonly>
                                    </div>
                                    <div class="col-lg-2 col-md-12 d-flex align-items-center gap-2">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button> 
                                        <a href="{{ route('attendance') }}" class="btn btn-secondary">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                        
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
                                    <th scope="col">Role</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Time Record</th>
                                    <th scope="col">Date Record</th>
                                    <th scope="col">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendance as $record)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $record->participant->name }}</td>
                                        <td>{{ $record->participant->participant_role }}</td>
                                        <td>{{ $record->participant->division }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->time_recorded)->format('h:i:s A') }}</td>
                                        <td>{{ $record->created_at->format('F j, Y') }}</td>
                                        <td>{{ $record->user->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No attendance record found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="mx-3">
                        {{ $attendance->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('input[name="date"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                        .format('YYYY-MM-DD'));
                });
            });
        </script>
    </section>

@endsection
