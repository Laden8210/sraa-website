@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class="pagetitle animate__animated animate__fadeInDown animate__delay-1s mt-4">
            <h3>Welcome to your dashboard!</h3>
            <p>| {{ Auth::user()->role }}, {{ Auth::user()->name }}</p>
        </div>

        <div class="row">

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card border shadow-sm shadow">



                    <div class="card-body">
                        <h5 class="card-title">Total Student Attendance<span> | Today</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-user'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $total_student }}</h6>
                                <span class="text-success small pt-1 fw-bold">{{$increase_coach}}%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card border shadow-sm shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Faculty Attendance<span> |Today</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-user'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $total_coach }}</h6>
                                <span class="text-success small pt-1 fw-bold">{{$increase_student}}%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeInDown  animate__delay-1s">
                <div class="card info-card student-card border shadow-sm shadow">
                    <div class="card-body">
                        <h5 class="card-title">Attendance Record <span>| Today</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-group'></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $total_attendance }}</h6>
                                <span class="text-success small pt-1 fw-bold">{{$increase_attendance}}%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex align-items-center mb-4 animate__animated  animate__fadeInDown  animate__delay-1s">
                <h5 class="me-2">Filter Attendance Record by Date |</h5>

                <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center">
                    <input name="date" type="date" class="form-control me-2" value="{{ request('date') }}"
                        style="width: 200px;">

                    <select name="division" class="form-select me-2" style="width: 200px;">
                        <option value="">Select Division</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>
                                {{ $division }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>


            <div class="col-12">
                <div class="col-12">
                    <div class="card  animate__animated animate__fadeInUp animate__delay-1s border shadow-sm shadow">

                        <div class="card-body">
                            <h5 class="card-title">Attendance <span>| Daily Record {{ request('date') ? ', ' . \Carbon\Carbon::parse(request('date'))->format('F j, Y') : ', ' . "Today" }} {{request('division')? ", for " . request('division') : ""}}</span></h5>

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
                                        @if ($attendance->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">No attendance records for
                                                    this date.</td>
                                            </tr>
                                        @else
                                            @foreach ($attendance as $record)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $record->participant->name }}</td>
                                                    <td>{{ $record->participant->participant_role }}</td>
                                                    <td>{{ $record->participant->division }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($record->time_recorded)->format('h:i:s A') }}</td>
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
                <div class="card  animate__animated animate__fadeInUp animate__delay-1s border shadow-sm shadow">


                    <div class="card-body">
                        <h5 class="card-title">Attendance <span> | Daily Record  {{ request('date') ? ', ' . \Carbon\Carbon::parse(request('date'))->format('F j, Y') : ', ' . "Today" }} {{request('division')? ", for " . request('division') : ""}}</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                    </div>

                </div>

            </div>

            <div class="col-12">
                <div class="card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Attendance <span>/Selected Date Range</span></h5>
                            <div class="w-25 position-relative">
                                <input type="text" id="date-range" class="form-control ps-4"
                                    placeholder="Select Date Range">
                                <i class="far fa-calendar position-absolute top-50 end-0 translate-middle-y pe-3"></i>
                            </div>
                        </div>
                        <div id="reportsChartRange"></div>

                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    function fetchAttendance(date = '', division = '') {
                        $.ajax({
                            url: "{{ url('/attendance-data') }}",
                            type: "GET",
                            data: {
                                date: date,
                                division: division
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
                                        categories: data.categories.map(function(category) {
                                            return moment(category, 'HH:mm').format('hh:mm A');
                                        })
                                    },
                                    yaxis: {
                                        labels: {
                                            formatter: function(value) {
                                                return Math.round(value);
                                            }
                                        },
                                        min: 0,
                                        max: function(max) {
                                            return max === 0 ? 5 :
                                            max; 
                                        },
                                        forceNiceScale: true
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
                    fetchAttendance("{{ request('date', '') }}", "{{ request('division', '') }}");

                    $('#date-filter').on('change', function() {
                        fetchAttendance($(this).val());
                    });

                    $('#date-range').daterangepicker({
                        opens: 'left',
                        maxSpan: {
                            days: 10
                        },
                        maxDate: moment().format('MM/DD/YYYY'),
                        locale: {
                            format: 'MM/DD/YYYY'
                        }
                    });

                    function fetchRangeAttendance(startDate, endDate) {
                        $.ajax({
                            url: "{{ url('/attendance-range-data') }}",
                            type: "GET",
                            data: {
                                start_date: startDate,
                                end_date: endDate
                            },
                            dataType: "json",
                            success: function(data) {
                                let RangechartOptions = {
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
                                        categories: data.categories.map(function(category) {
                                            return moment(category, 'YYYY-MM-DD').format('MMM D, YYYY');
                                        })
                                    },
                                    yaxis: {
                                        labels: {
                                            formatter: function(value) {
                                                return Math.round(value);
                                            }
                                        },
                                        min: 0,
                                        max: function(max) {
                                            return max === 0 ? 5 :
                                            max; 
                                        },
                                        forceNiceScale: true
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'MM/DD/YYYY'
                                        }
                                    }
                                };

                                if (window.rangeattendanceChart) {
                                    window.rangeattendanceChart.destroy();
                                }

                                window.rangeattendanceChart = new ApexCharts(document.querySelector(
                                    "#reportsChartRange"), RangechartOptions);
                                window.rangeattendanceChart.render();
                            },
                            error: function(xhr, status, error) {
                                console.error("Error fetching attendance data:", error);
                            }
                        });
                    }
                    fetchRangeAttendance("", "");

                    // Handle Date Range Selection
                    $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                        let startDate = picker.startDate.format('MM/DD/YYYY');
                        let endDate = picker.endDate.format('MM/DD/YYYY');
                        fetchRangeAttendance(startDate, endDate);
                    });

                });
            </script>

    </section>



@endsection
