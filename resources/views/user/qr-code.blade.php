@extends('layouts.user')

@section('title', 'Welcome')
@section('content')

    <section class="container ">
        <div>
            <div class=" animate__animated animate__fadeInDown  animate__delay-1s">
                <h3 class="text-start mt-5">Generate and Download Qr Code</h3>
            </div>


            <div
                class="d-flex justify-content-between align-items-center mt-3  animate__animated  animate__fadeIn  animate__delay-1s">
                <form action="" method="post">
                    <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                        <select class="form-select" name="division" id="division">
                            <option value="Koronadal">Koronadal</option>
                            <option value="General Santos">General Santos</option>
                            <option value="Tantangan">Tantangan</option>
                            <option value="Surallah">Surallah</option>
                            <option value="Polomolok">Polomolok</option>
                        </select>

                        <select name="school" class="form-select" id="school">
                            <option value="School 1">School 1</option>
                            <option value="School 2">School 2</option>
                            <option value="School 3">School 3</option>
                            <option value="School 4">School 4</option>
                            <option value="School 5">School 5</option>
                        </select>


                        <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center gap-2">
                    <button class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Download All</button>
                    <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i> Print All</button>
                </div>
            </div>





        </div>
        <div class="row p-2">
            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                <div class="card info-card student-card w-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">

                        <!-- QR Code -->
                        <div class="d-flex align-items-center">
                            <img src="https://png.pngtree.com/png-clipart/20220605/original/pngtree-black-qr-code-for-web-png-image_7964376.png"
                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>

                        <!-- Student Info & Buttons -->
                        <div class="flex-grow-1 ms-3">
                            <div>
                                <h6 class="qr-card-title mb-1">Student Name: <span class="fw-bold">John Michael
                                        Domingo</span></h6>
                                <h6 class="qr-card-title">Division: <span class="fw-bold">Koronadal</span></h6>
                            </div>


                            <div class="d-flex gap-2 mt-2 justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button>
                                <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                <div class="card info-card student-card w-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">

                        <!-- QR Code -->
                        <div class="d-flex align-items-center">
                            <img src="https://png.pngtree.com/png-clipart/20220605/original/pngtree-black-qr-code-for-web-png-image_7964376.png"
                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>

                        <!-- Student Info & Buttons -->
                        <div class="flex-grow-1 ms-3">
                            <div>
                                <h6 class="qr-card-title mb-1">Student Name: <span class="fw-bold">John Michael
                                        Domingo</span></h6>
                                <h6 class="qr-card-title">Division: <span class="fw-bold">Koronadal</span></h6>
                            </div>


                            <div class="d-flex gap-2 mt-2 justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button>
                                <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                <div class="card info-card student-card w-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">

                        <!-- QR Code -->
                        <div class="d-flex align-items-center">
                            <img src="https://png.pngtree.com/png-clipart/20220605/original/pngtree-black-qr-code-for-web-png-image_7964376.png"
                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>

                        <!-- Student Info & Buttons -->
                        <div class="flex-grow-1 ms-3">
                            <div>
                                <h6 class="qr-card-title mb-1">Student Name: <span class="fw-bold">John Michael
                                        Domingo</span></h6>
                                <h6 class="qr-card-title">Division: <span class="fw-bold">Koronadal</span></h6>
                            </div>


                            <div class="d-flex gap-2 mt-2 justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button>
                                <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                <div class="card info-card student-card w-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">

                        <!-- QR Code -->
                        <div class="d-flex align-items-center">
                            <img src="https://png.pngtree.com/png-clipart/20220605/original/pngtree-black-qr-code-for-web-png-image_7964376.png"
                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>

                        <!-- Student Info & Buttons -->
                        <div class="flex-grow-1 ms-3">
                            <div>
                                <h6 class="qr-card-title mb-1">Student Name: <span class="fw-bold">John Michael
                                        Domingo</span></h6>
                                <h6 class="qr-card-title">Division: <span class="fw-bold">Koronadal</span></h6>
                            </div>


                            <div class="d-flex gap-2 mt-2 justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-download"
                                        aria-hidden="true"></i></button>
                                <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-6  animate__animated  animate__fadeIn  animate__delay-1s">
                <div class="card info-card student-card w-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-3">

                        <!-- QR Code -->
                        <div class="d-flex align-items-center">
                            <img src="https://png.pngtree.com/png-clipart/20220605/original/pngtree-black-qr-code-for-web-png-image_7964376.png"
                                alt="QR Code" class="img-fluid" style="width: 100px; height: 100px;">
                        </div>

                        <!-- Student Info & Buttons -->
                        <div class="flex-grow-1 ms-3">
                            <div>
                                <h6 class="qr-card-title mb-1">Student Name: <span class="fw-bold">John Michael
                                        Domingo</span></h6>
                                <h6 class="qr-card-title">Division: <span class="fw-bold">Koronadal</span></h6>
                            </div>


                            <div class="d-flex gap-2 mt-2 justify-content-end">
                                <button class="btn btn-primary"><i class="fa fa-download"
                                        aria-hidden="true"></i></button>
                                <button class="btn btn-secondary"><i class="fa fa-print" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>


    </section>



@endsection
