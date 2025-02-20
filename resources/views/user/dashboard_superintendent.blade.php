@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="animate__animated  animate__fadeInDown  animate__delay-1s">
            <h3 class="text-start mt-5">Welcome to your dashboard</h3>
        </div>
        <div class="row p-2">

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card">



                    <div class="card-body">
                        <h5 class="card-title">Total Student <span></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$total_student}}</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Faculty <span></span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$total_coach}}</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card">
                    <div class="card-body">
                        <h5 class="card-title">Attendance Record <span>| Today</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-cart'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $total_attendance }}</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
                <h5 class="me-2">Filter Attendance Record by Date |</h5>

                <form method="GET" action="{{ route('dashboard') }}" class="d-flex">
                    <input name="date" type="date" class="form-control me-2" value="{{ request('date') }}"
                        style="width: 200px;">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="col-12">
                <div class="col-12">
                    <div class="card  animate__animated animate__fadeInUp animate__delay-1s">

                        <div class="card-body">
                            <h5 class="card-title">Attendance <span>/Daily Record</span></h5>

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
                                        @if ($attendance->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No attendance records for
                                                    this date.</td>
                                            </tr>
                                        @else
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
                                        @endif
                                    </tbody>

                                </table>

                            </div>
                            <div class="mx-3">
                                {{ $attendance->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card  animate__animated animate__fadeInUp animate__delay-1s">


                    <div class="card-body">
                        <h5 class="card-title">Attendance <span>/Daily Record</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                            $(document).ready(function() {
                                function fetchAttendance(date = '') {
                                    $.ajax({
                                        url: "{{ url('/attendance-data') }}",
                                        type: "GET",
                                        data: {
                                            date: date
                                        }, // Pass selected date
                                        dataType: "json",
                                        success: function(data) {
                                            let chartOptions = {
                                                series: [{
                                                    name: 'Attendance',
                                                    data: data.data
                                                }],
                                                chart: {
                                                    height: 350,
                                                    type: 'bar',
                                                    toolbar: {
                                                        show: false
                                                    }
                                                },
                                                markers: {
                                                    size: 4
                                                },
                                                colors: ['#4154f1'],
                                                fill: {
                                                    type: "gradient",
                                                    gradient: {
                                                        shadeIntensity: 1,
                                                        opacityFrom: 0.3,
                                                        opacityTo: 0.4,
                                                        stops: [0, 90, 100]
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                stroke: {
                                                    curve: 'smooth',
                                                    width: 2
                                                },
                                                xaxis: {
                                                    categories: data.categories
                                                },
                                                tooltip: {
                                                    x: {
                                                        format: 'HH:mm'
                                                    }
                                                }
                                            };

                                            // Destroy existing chart if it exists
                                            if (window.attendanceChart) {
                                                window.attendanceChart.destroy();
                                            }

                                            // Render new chart
                                            window.attendanceChart = new ApexCharts(document.querySelector("#reportsChart"),
                                                chartOptions);
                                            window.attendanceChart.render();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error fetching attendance data:", error);
                                        }
                                    });
                                }

                                // Load attendance on page load with current date
                                fetchAttendance("{{ request('date', '') }}");

                                // Listen for date change
                                $('#date-filter').on('change', function() {
                                    fetchAttendance($(this).val());
                                });
                            });

                        </script>

                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>


        </div>

    </section>



@endsection
