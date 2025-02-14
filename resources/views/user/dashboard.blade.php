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
                                <h6>145</h6>
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
                                <h6>145</h6>
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
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>

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
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Time In',
                                        data: [31, 40, 28, 51, 42, 82, 56],
                                    }, {
                                        name: 'Time Out',
                                        data: [11, 32, 45, 32, 34, 52, 41]
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'bar',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
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
                                        type: 'datetime',
                                        categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                            "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                            "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                            "2018-09-19T06:30:00.000Z"
                                        ]
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'dd/MM/yy HH:mm'
                                        },
                                    }
                                }).render();
                            });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>
            </div>
        </div>

    </section>



@endsection
