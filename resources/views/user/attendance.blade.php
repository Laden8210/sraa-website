@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div class=" animate__animated  animate__fadeInDown  animate__delay-1s">
            <h3 class="text-start mt-5">Student List</h3>
        </div>
        <div class="row p-2">


            <div class="col-xxl-6 col-md-6">
                <div class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s">



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
                <div class="card info-card student-card  animate__animated  animate__fadeIn  animate__delay-1s">
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
                <div class="card px-2 py-4  animate__animated  animate__fadeIn  animate__delay-1s">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" class="form-control" placeholder="Search">

                                <select name="" id="" class="form-select">
                                    <option value="">Select Division</option>
                                </select>
                                <button class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>


                            <button class="btn btn-primary">Add Student</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Time Record</th>
                                    <th scope="col">Date Record</th>
                                    <th scope="col">Attendance Type</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Koronadal</td>
                                    <td>8:00 AM</td>
                                    <td>June 1, 2021</td>
                                    <td>Time Out</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>



@endsection
